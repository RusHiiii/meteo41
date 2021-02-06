<?php

namespace App\Core\Tactician\Handler\Post;

use App\Core\Exception\Post\PostNotFoundException;
use App\Core\Exception\User\UserNotFoundException;
use App\Core\Factory\PostFactory;
use App\Core\Tactician\Command\Post\EditPostCommand;
use App\Repository\Doctrine\PostRepository;
use App\Repository\Doctrine\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class EditPostHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * EditPostHandler constructor.
     * @param UserRepository $userRepository
     * @param PostFactory $postFactory
     * @param EntityManagerInterface $entityManager
     * @param PostRepository $postRepository
     */
    public function __construct(
        UserRepository $userRepository,
        PostFactory $postFactory,
        EntityManagerInterface $entityManager,
        PostRepository $postRepository
    ) {
        $this->userRepository = $userRepository;
        $this->postFactory = $postFactory;
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
    }

    public function handle(EditPostCommand $postCommand)
    {
        $user = $this->userRepository->find($postCommand->getUserId());
        if ($user === null) {
            throw new UserNotFoundException();
        }

        $post = $this->postRepository->find($postCommand->getId());
        if ($post === null) {
            throw new PostNotFoundException();
        }

        $post = $this->postFactory->editPostFromCommand($post, $postCommand, $user);
    }
}
