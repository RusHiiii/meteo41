<?php

namespace App\Controller;

use App\Core\Constant\Contact\ApiSearch;
use App\Core\Exception\Contact\ContactLimitException;
use App\Core\Exception\Contact\ContactNotFoundException;
use App\Core\Exception\InvalidCommandException;
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
use App\Repository\Doctrine\ContactRepository;
use App\Repository\Doctrine\WeatherStationRepository;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * WeatherDataController constructor.
     * @param CommandBus $commandBus
     * @param CommandMapper $commandMapper
     * @param ErrorFactory $errorFactory
     * @param SerializerInterface $serializer
     * @param WeatherStationRepository $weatherStationRepository
     */
    public function __construct(
        CommandBus $commandBus,
        CommandMapper $commandMapper,
        ErrorFactory $errorFactory,
        SerializerInterface $serializer,
        WeatherStationRepository $weatherStationRepository
    ) {
        $this->commandBus = $commandBus;
        $this->commandMapper = $commandMapper;
        $this->errorFactory = $errorFactory;
        $this->serializer = $serializer;
        $this->weatherStationRepository = $weatherStationRepository;
    }

    /**
     * @Route("/api/weatherData", name="register_data", methods={"GET"})
     */
    public function registerWeatherDataAction(Request $request): Response
    {
        $weatherData = $request->query->all();
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
}
