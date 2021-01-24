<?php

namespace App\Controller;

use App\Core\Constant\User\ApiSearch;
use App\Core\Exception\InvalidCommandException;
use App\Core\Exception\User\BadPasswordConfirmationException;
use App\Core\Exception\User\BadPasswordSecurityException;
use App\Core\Exception\User\CannotEditMailException;
use App\Core\Exception\User\RoleNotFoundException;
use App\Core\Exception\User\UserAlreadyExistException;
use App\Core\Exception\User\UserNotFoundException;
use App\Core\Factory\ErrorFactory;
use App\Core\Response\SerializedErrorResponse;
use App\Core\Response\SerializedResponse;
use App\Core\Tactician\Command\User\DeleteUserCommand;
use App\Core\Tactician\Command\User\EditUserCommand;
use App\Core\Tactician\Command\User\RegisterUserCommand;
use App\Core\Tactician\Mapper\CommandMapper;
use App\Core\Transformer\UserTransformer;
use App\Repository\Doctrine\UserRepository;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
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
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserTransformer
     */
    private $userTransformer;

    public function __construct(
        CommandBus $commandBus,
        CommandMapper $commandMapper,
        ErrorFactory $errorFactory,
        SerializerInterface $serializer,
        UserRepository $userRepository,
        UserTransformer $userTransformer
    ) {
        $this->commandBus = $commandBus;
        $this->commandMapper = $commandMapper;
        $this->errorFactory = $errorFactory;
        $this->serializer = $serializer;
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
    }

    /**
     * @Route("/api/user", name="register_user", methods={"POST"})
     */
    public function registerUserAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            $command = $this
                ->commandMapper
                ->map($request->getContent(), RegisterUserCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        try {
            $this->commandBus->handle($command);
        } catch (UserAlreadyExistException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        } catch (BadPasswordConfirmationException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        } catch (BadPasswordSecurityException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        } catch (RoleNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        }

        return new SerializedResponse(null, 201);
    }

    /**
     * @Route("/api/user/{id}", name="delete_user", methods={"DELETE"})
     */
    public function deleteUserAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $command = new DeleteUserCommand($id);

        try {
            $this->commandBus->handle($command);
        } catch (UserNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        return new SerializedResponse(null, 204);
    }

    /**
     * @Route("/api/user/{id}", name="update_user", methods={"PUT"})
     */
    public function updateUserAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        try {
            /** @var EditUserCommand */
            $command = $this
                ->commandMapper
                ->map($request->getContent(), EditUserCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        $command->setId($id);

        try {
            $this->commandBus->handle($command);
        } catch (UserNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        } catch (CannotEditMailException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        } catch (BadPasswordConfirmationException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        }

        return new SerializedResponse(null, 204);
    }

    /**
     * @Route("/api/user/{id}", name="show_user", methods={"GET"})
     */
    public function showUserAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        $user = $this->userRepository->find($id);
        if ($user === null) {
            $error = $this->errorFactory->create(new UserNotFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        $user = $this->userTransformer->transformUserToView($user);

        return new SerializedResponse($this->serializer->serialize($user, 'json'), 200);
    }

    /**
     * @Route("/api/user", name="list_user", methods={"GET"})
     */
    public function listUserAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        try {
            $contacts = $this->userRepository->findPaginatedUsers(
                $request->query->get('searchBy', []),
                $request->query->get('order', ApiSearch::USER_ORDER_BY_ASC),
                $request->query->get('page', 1),
                $request->query->get('maxResult', 10)
            );
        } catch (\InvalidArgumentException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 400);
        }

        $users = $this->userTransformer->transformUserToSearchView($contacts);

        return new SerializedResponse($this->serializer->serialize($users, 'json'), 200);
    }
}
