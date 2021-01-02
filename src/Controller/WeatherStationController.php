<?php

namespace App\Controller;

use App\Core\Constant\Contact\ApiSearch;
use App\Core\Exception\Contact\ContactLimitException;
use App\Core\Exception\Contact\ContactNotFoundException;
use App\Core\Exception\InvalidCommandException;
use App\Core\Exception\WeatherStation\DuplicateWeatherStationFoundException;
use App\Core\Exception\WeatherStation\WeatherStationNotFoundException;
use App\Core\Factory\ErrorFactory;
use App\Core\Response\SerializedErrorResponse;
use App\Core\Response\SerializedResponse;
use App\Core\Tactician\Command\Contact\DeleteContactCommand;
use App\Core\Tactician\Command\Contact\EditContactCommand;
use App\Core\Tactician\Command\Contact\RegisterContactCommand;
use App\Core\Tactician\Command\WeatherStation\DeleteWeatherStationCommand;
use App\Core\Tactician\Command\WeatherStation\RegisterWeatherStationCommand;
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
}
