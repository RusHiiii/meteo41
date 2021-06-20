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
use App\Core\Transformer\ObservationTransformer;
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

    /**
     * @var ObservationTransformer
     */
    private $observationTransformer;

    public function __construct(
        CommandBus $commandBus,
        CommandMapper $commandMapper,
        ErrorFactory $errorFactory,
        SerializerInterface $serializer,
        ObservationRepository $observationRepository,
        ObservationTransformer $observationTransformer
    ) {
        $this->commandBus = $commandBus;
        $this->commandMapper = $commandMapper;
        $this->errorFactory = $errorFactory;
        $this->serializer = $serializer;
        $this->observationRepository = $observationRepository;
        $this->observationTransformer = $observationTransformer;
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

    /**
     * @Route("/api/weatherStation/observation/last/{reference}", name="show_observation", methods={"GET"})
     */
    public function showLastObservationAction(Request $request, $reference): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        $observation = $this->observationRepository->findLastObservationByWeatherStationReference($reference);
        if ($observation === null) {
            $error = $this->errorFactory->create(new ObservationNotFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 400);
        }

        $observation = $this->observationTransformer->transformObservationToView($observation);

        return new SerializedResponse($this->serializer->serialize($observation, 'json'), 200);
    }

    /**
     * @Route("/api/observation", name="list_observation", methods={"GET"})
     */
    public function listObservationAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        try {
            $observations = $this->observationRepository->findPaginatedObservation(
                $request->query->get('searchBy', []),
                $request->query->get('order', \App\Core\Constant\Observation\ApiSearch::OBSERVATION_ORDER_BY_DESC),
                $request->query->get('page', 1),
                $request->query->get('maxResult', 10)
            );
        } catch (\InvalidArgumentException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 400);
        }

        $observations = $this->observationTransformer->transformObservationToSearchView($observations);

        return new SerializedResponse($this->serializer->serialize($observations, 'json'), 200);
    }

    /**
     * @Route("/api/observation/{id}", name="show_observation", methods={"GET"})
     */
    public function showObservationAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        $observation = $this->observationRepository->find($id);
        if ($observation === null) {
            $error = $this->errorFactory->create(new ObservationNotFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        $observation = $this->observationTransformer->transformObservationToView($observation);

        return new SerializedResponse($this->serializer->serialize($observation, 'json'), 200);
    }
}
