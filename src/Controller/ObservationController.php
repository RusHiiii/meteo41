<?php

namespace App\Controller;

use App\Core\Constant\Post\ApiSearch;
use App\Core\Exception\InvalidCommandException;
use App\Core\Exception\Observation\ObservationMessageRequiredException;
use App\Core\Exception\Observation\ObservationNotFoundException;
use App\Core\Exception\Post\PostNotFoundException;
use App\Core\Exception\User\UserNotFoundException;
use App\Core\Exception\WeatherStation\WeatherStationNotFoundException;
use App\Core\Factory\ErrorFactory;
use App\Core\Response\SerializedErrorResponse;
use App\Core\Response\SerializedResponse;
use App\Core\Tactician\Command\Observation\DeleteObservationCommand;
use App\Core\Tactician\Command\Observation\EditObservationCommand;
use App\Core\Tactician\Command\Observation\RegisterObservationCommand;
use App\Core\Tactician\Command\Post\DeletePostCommand;
use App\Core\Tactician\Command\Post\EditPostCommand;
use App\Core\Tactician\Command\Post\RegisterPostCommand;
use App\Core\Tactician\Command\WeatherStation\DeleteWeatherStationCommand;
use App\Core\Tactician\Mapper\CommandMapper;
use App\Core\Transformer\PostTransformer;
use App\Repository\Doctrine\ObservationRepository;
use App\Repository\Doctrine\PostRepository;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ObservationController extends AbstractController
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
     * @var ObservationRepository
     */
    private $observationRepository;

    public function __construct(
        CommandBus $commandBus,
        CommandMapper $commandMapper,
        ErrorFactory $errorFactory,
        SerializerInterface $serializer,
        ObservationRepository $observationRepository
    ) {
        $this->commandBus = $commandBus;
        $this->commandMapper = $commandMapper;
        $this->errorFactory = $errorFactory;
        $this->serializer = $serializer;
        $this->observationRepository = $observationRepository;
    }

    /**
     * @Route("/api/observation", name="register_observation", methods={"POST"})
     */
    public function registerObservationAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        try {
            /**
             * @var RegisterObservationCommand
             */
            $command = $this
                ->commandMapper
                ->map($request->getContent(), RegisterObservationCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        $command->setUserId($this->getUser()->getId());

        try {
            $this->commandBus->handle($command);
        } catch (UserNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        } catch (WeatherStationNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        } catch (ObservationMessageRequiredException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        }

        return new SerializedResponse(null, 201);
    }

    /**
     * @Route("/api/observation/{id}", name="edit_observation", methods={"PUT"})
     */
    public function updateObservationAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        try {
            /** @var EditObservationCommand $command */
            $command = $this
                ->commandMapper
                ->map($request->getContent(), EditObservationCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        $command->setId($id);
        $command->setUserId($this->getUser()->getId());

        try {
            $this->commandBus->handle($command);
        } catch (WeatherStationNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 400);
        } catch (ObservationNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        return new SerializedResponse(null, 204);
    }

    /**
     * @Route("/api/observation/{id}", name="delete_observation", methods={"DELETE"})
     */
    public function deleteObservationAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        $command = new DeleteObservationCommand($id);

        try {
            $this->commandBus->handle($command);
        } catch (ObservationNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        return new SerializedResponse(null, 204);
    }
}
