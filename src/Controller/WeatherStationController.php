<?php

namespace App\Controller;

use App\Core\Constant\WeatherStation\ApiSearch;
use App\Core\Exception\InvalidCommandException;
use App\Core\Exception\WeatherStation\DuplicateWeatherStationFoundException;
use App\Core\Exception\WeatherStation\WeatherStationNotFoundException;
use App\Core\Factory\ErrorFactory;
use App\Core\Response\SerializedErrorResponse;
use App\Core\Response\SerializedResponse;
use App\Core\Tactician\Command\WeatherStation\DeleteWeatherStationCommand;
use App\Core\Tactician\Command\WeatherStation\EditWeatherStationCommand;
use App\Core\Tactician\Command\WeatherStation\RegisterWeatherStationCommand;
use App\Core\Tactician\Mapper\CommandMapper;
use App\Core\Transformer\WeatherStationTransformer;
use App\Repository\Doctrine\WeatherStationRepository;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class WeatherStationController extends AbstractController
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
     * @var WeatherStationTransformer
     */
    private $weatherStationTransformer;

    public function __construct(
        CommandBus $commandBus,
        CommandMapper $commandMapper,
        ErrorFactory $errorFactory,
        SerializerInterface $serializer,
        WeatherStationRepository $weatherStationRepository,
        WeatherStationTransformer $weatherStationTransformer
    ) {
        $this->commandBus = $commandBus;
        $this->commandMapper = $commandMapper;
        $this->errorFactory = $errorFactory;
        $this->serializer = $serializer;
        $this->weatherStationRepository = $weatherStationRepository;
        $this->weatherStationTransformer = $weatherStationTransformer;
    }

    /**
     * @Route("/api/weatherStation", name="register_weather_station", methods={"POST"})
     */
    public function registerWeatherStationAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            $command = $this
                ->commandMapper
                ->map($request->getContent(), RegisterWeatherStationCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        try {
            $this->commandBus->handle($command);
        } catch (DuplicateWeatherStationFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        }

        return new SerializedResponse(null, 201);
    }

    /**
     * @Route("/api/weatherStation/{id}", name="edit_weather_station", methods={"PUT"})
     */
    public function editWeatherStationAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            /** @var EditWeatherStationCommand $command */
            $command = $this
                ->commandMapper
                ->map($request->getContent(), EditWeatherStationCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        $command->setId($id);

        try {
            $this->commandBus->handle($command);
        } catch (WeatherStationNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        return new SerializedResponse(null, 204);
    }

    /**
     * @Route("/api/weatherStation/{id}", name="delete_weather_station", methods={"DELETE"})
     */
    public function deleteContactAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $command = new DeleteWeatherStationCommand($id);

        try {
            $this->commandBus->handle($command);
        } catch (WeatherStationNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        return new SerializedResponse(null, 204);
    }

    /**
     * @Route("/api/weatherStation/{id}", name="show_weather_station", methods={"GET"})
     */
    public function showWeatherStationAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        $weatherStation = $this->weatherStationRepository->find($id);
        if ($weatherStation === null) {
            $error = $this->errorFactory->create(new WeatherStationNotFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        $contact = $this->weatherStationTransformer->transformWeatherStationToView($weatherStation);

        return new SerializedResponse($this->serializer->serialize($contact, 'json'), 200);
    }

    /**
     * @Route("/api/weatherStation", name="list_weather_station", methods={"GET"})
     */
    public function listWeatherStationAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        try {
            $weatherStations = $this->weatherStationRepository->findPaginatedWeatherStations(
                $request->query->get('searchBy', []),
                $request->query->get('order', ApiSearch::WEATHER_STATION_ORDER_BY_ASC),
                $request->query->get('page', 1),
                $request->query->get('maxResult', 10)
            );
        } catch (\InvalidArgumentException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 400);
        }

        $contact = $this->weatherStationTransformer->transformWeatherStationToSearchView($weatherStations);

        return new SerializedResponse($this->serializer->serialize($contact, 'json'), 200);
    }
}
