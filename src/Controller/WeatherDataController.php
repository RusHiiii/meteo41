<?php

namespace App\Controller;

use App\Core\Constant\Contact\ApiSearch;
use App\Core\Converter\Period\PeriodConverter;
use App\Core\Exception\Contact\ContactLimitException;
use App\Core\Exception\Contact\ContactNotFoundException;
use App\Core\Exception\InvalidCommandException;
use App\Core\Exception\WeatherData\NoWeatherDataFoundException;
use App\Core\Exception\WeatherData\NoWeatherDataReportFoundException;
use App\Core\Exception\WeatherStation\WeatherStationNotFoundException;
use App\Core\Factory\ErrorFactory;
use App\Core\Response\SerializedErrorResponse;
use App\Core\Response\SerializedResponse;
use App\Core\Tactician\Command\Contact\DeleteContactCommand;
use App\Core\Tactician\Command\Contact\EditContactCommand;
use App\Core\Tactician\Command\Contact\RegisterContactCommand;
use App\Core\Tactician\Command\WeatherData\RegisterWeatherDataCommand;
use App\Core\Tactician\Mapper\CommandMapper;
use App\Core\Transformer\ContactTransformer;
use App\Core\Transformer\WeatherDataTransformer;
use App\Repository\Doctrine\ContactRepository;
use App\Repository\Doctrine\WeatherDataRepository;
use App\Repository\Doctrine\WeatherStationRepository;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;

class WeatherDataController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var CommandMapper
     */
    private $commandMapper;

    /**
     * @var ErrorFactory
     */
    private $errorFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var WeatherStationRepository
     */
    private $weatherStationRepository;

    /**
     * @var WeatherDataRepository
     */
    private $weatherDataRepository;

    /**
     * @var WeatherDataTransformer
     */
    private $weatherDataTransformer;

    /**
     * @var PeriodConverter
     */
    private $periodConverter;

    /**
     * WeatherDataController constructor.
     * @param CommandBus $commandBus
     * @param CommandMapper $commandMapper
     * @param ErrorFactory $errorFactory
     * @param SerializerInterface $serializer
     * @param WeatherStationRepository $weatherStationRepository
     * @param WeatherDataRepository $weatherDataRepository
     * @param WeatherDataTransformer $weatherDataTransformer
     * @param PeriodConverter $periodConverter
     */
    public function __construct(
        CommandBus $commandBus,
        CommandMapper $commandMapper,
        ErrorFactory $errorFactory,
        SerializerInterface $serializer,
        WeatherStationRepository $weatherStationRepository,
        WeatherDataRepository $weatherDataRepository,
        WeatherDataTransformer $weatherDataTransformer,
        PeriodConverter $periodConverter
    ) {
        $this->commandBus = $commandBus;
        $this->commandMapper = $commandMapper;
        $this->errorFactory = $errorFactory;
        $this->serializer = $serializer;
        $this->weatherStationRepository = $weatherStationRepository;
        $this->weatherDataRepository = $weatherDataRepository;
        $this->weatherDataTransformer = $weatherDataTransformer;
        $this->periodConverter = $periodConverter;
    }

    /**
     * @Route("/api/weatherData", name="register_data", methods={"POST"})
     */
    public function registerWeatherDataAction(Request $request): Response
    {
        parse_str($request->getContent(), $weatherData);

        if (!array_key_exists('PASSKEY', $weatherData)) {
            throw new AccessDeniedException();
        }

        $weatherStation = $this->weatherStationRepository->findByPasskey($weatherData['PASSKEY']);
        if ($weatherStation === null) {
            throw new NotFoundHttpException();
        }

        try {
            /** @var RegisterWeatherDataCommand $command */
            $command = $this
                ->commandMapper
                ->map(json_encode($weatherData), RegisterWeatherDataCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        $command->setWeatherStationId($weatherStation->getId());

        try {
            $this->commandBus->handle($command);
        } catch (WeatherStationNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        return new SerializedResponse(null, 201);
    }

    /**
     * @Route("/api/weatherData/{reference}/currentData/summary", name="show_summary_data", methods={"GET"})
     */
    public function showWeatherDataSummaryAction(Request $request, $reference): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        $weatherData = $this->weatherDataRepository->findLastInsertedByWeatherStationReference($reference);
        if ($weatherData === null) {
            $error = $this->errorFactory->create(new NoWeatherDataFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 400);
        }

        $weatherData = $this->weatherDataTransformer->transformWeatherDataToSummary($weatherData);

        return new SerializedResponse($this->serializer->serialize($weatherData, 'json'), 200);
    }

    /**
     * @Route("/api/weatherData/{reference}/currentData/detail", name="show_detail_data", methods={"GET"})
     */
    public function showWeatherDataDetailAction(Request $request, $reference): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        $weatherDataLastHour = $this->weatherDataRepository->findLastHourByWeatherStationReference($reference);

        $weatherDataCurrent = $this->weatherDataRepository->findLastInsertedByWeatherStationReference($reference);
        if ($weatherDataCurrent === null) {
            $error = $this->errorFactory->create(new NoWeatherDataFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 400);
        }

        $weatherData = $this->weatherDataTransformer->transformWeatherDataToDetail($weatherDataCurrent, $weatherDataLastHour);

        return new SerializedResponse($this->serializer->serialize($weatherData, 'json'), 200);
    }

    /**
     * @Route("/api/weatherData/{reference}/history/{period}", name="show_history_data", requirements={"period"="daily|weekly|monthly|yearly|record"}, methods={"GET"})
     */
    public function showWeatherDataHistoryAction(Request $request, $reference, $period): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        $weatherStation = $this->weatherStationRepository->findByReference($reference);
        if ($weatherStation === null) {
            $error = $this->errorFactory->create(new WeatherStationNotFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        list($endDate, $startDate) = $this->periodConverter->convertPeriodToDate($period);

        $weatherDataPeriod = $this->weatherDataRepository->findWeatherDataHistory($startDate, $endDate, $period, $reference);
        if (!$weatherDataPeriod['has_data']) {
            $error = $this->errorFactory->create(new NoWeatherDataReportFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 400);
        }

        $weatherDataView = $this->weatherDataTransformer->transformWeatherDataToPeriod($weatherDataPeriod, $weatherStation);

        return new SerializedResponse($this->serializer->serialize($weatherDataView, 'json'), 200);
    }

    /**
     * @Route("/api/weatherData/{reference}/graph/{period}", name="show_graph_data", requirements={"period"="daily|weekly|monthly|yearly"}, methods={"GET"})
     */
    public function showWeatherDataGraphAction(Request $request, $reference, $period): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        $weatherStation = $this->weatherStationRepository->findByReference($reference);
        if ($weatherStation === null) {
            $error = $this->errorFactory->create(new WeatherStationNotFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        list($endDate, $startDate) = $this->periodConverter->convertPeriodToDate($period);

        $weatherDataGraph = $this->weatherDataRepository->findWeatherDataGraph($startDate, $endDate, $period, $reference);
        if (!$weatherDataGraph) {
            $error = $this->errorFactory->create(new NoWeatherDataReportFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 400);
        }

        $weatherDataView = $this->weatherDataTransformer->transformWeatherDataGraphSearchView($weatherStation, $weatherDataGraph, new \DateTime($startDate), new \DateTime($endDate));

        return new SerializedResponse($this->serializer->serialize($weatherDataView, 'json'), 200);
    }
}
