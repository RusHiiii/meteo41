<?php

namespace App\Controller;

use App\Core\Exception\InvalidCommandException;
use App\Core\Exception\Post\PostNotFoundException;
use App\Core\Exception\User\UserNotFoundException;
use App\Core\Factory\ErrorFactory;
use App\Core\Response\SerializedErrorResponse;
use App\Core\Response\SerializedResponse;
use App\Core\Tactician\Command\Post\DeletePostCommand;
use App\Core\Tactician\Command\Post\EditPostCommand;
use App\Core\Tactician\Command\Post\RegisterPostCommand;
use App\Core\Tactician\Mapper\CommandMapper;
use App\Core\Transformer\PostTransformer;
use App\Repository\Doctrine\PostRepository;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PostController extends AbstractController
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
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var PostTransformer
     */
    private $postTransformer;

    public function __construct(
        CommandBus $commandBus,
        CommandMapper $commandMapper,
        ErrorFactory $errorFactory,
        SerializerInterface $serializer,
        PostRepository $postRepository,
        PostTransformer $postTransformer
    ) {
        $this->commandBus = $commandBus;
        $this->commandMapper = $commandMapper;
        $this->errorFactory = $errorFactory;
        $this->serializer = $serializer;
        $this->postRepository = $postRepository;
        $this->postTransformer = $postTransformer;
    }

    /**
     * @Route("/api/post", name="register_post", methods={"POST"})
     */
    public function registerPostAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        try {
            /**
             * @var RegisterPostCommand
             */
            $command = $this
                ->commandMapper
                ->map($request->getContent(), RegisterPostCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        $command->setUserId($this->getUser()->getId());

        try {
            $this->commandBus->handle($command);
        } catch (UserNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'));
        }

        return new SerializedResponse(null, 201);
    }

    /**
     * @Route("/api/post/{id}", name="delete_post", methods={"DELETE"})
     */
    public function deletePostAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        $command = new DeletePostCommand($id);

        try {
            $this->commandBus->handle($command);
        } catch (PostNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        return new SerializedResponse(null, 204);
    }

    /**
     * @Route("/api/post/{id}", name="update_post", methods={"PUT"})
     */
    public function updatePostAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        try {
            /** @var EditPostCommand */
            $command = $this
                ->commandMapper
                ->map($request->getContent(), EditPostCommand::class);
        } catch (InvalidCommandException $e) {
            return new SerializedErrorResponse($e->getMessage(), 400);
        }

        $command->setId($id);
        $command->setUserId($this->getUser()->getId());

        try {
            $this->commandBus->handle($command);
        } catch (UserNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        } catch (PostNotFoundException $e) {
            $error = $this->errorFactory->create($e);
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        return new SerializedResponse(null, 204);
    }

    /**
     * @Route("/api/post/{id}", name="show_post", methods={"GET"})
     */
    public function showPostAction(Request $request, $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');

        $post = $this->postRepository->find($id);
        if ($post === null) {
            $error = $this->errorFactory->create(new PostNotFoundException());
            return new SerializedErrorResponse($this->serializer->serialize($error, 'json'), 404);
        }

        $post = $this->postTransformer->transformPostToView($post);

        return new SerializedResponse($this->serializer->serialize($post, 'json'), 200);
    }
}
