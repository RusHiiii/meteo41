<?php

namespace App\Core\Tactician\Handler\Post;

use App\Core\Exception\User\UserNotFoundException;
use App\Core\Factory\PostFactory;
use App\Core\Tactician\Command\Post\RegisterPostCommand;
use App\Repository\Doctrine\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class RegisterPostHandler
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
     * RegisterPostHandler constructor.
     * @param UserRepository $userRepository
     * @param PostFactory $postFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        UserRepository $userRepository,
        PostFactory $postFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->postFactory = $postFactory;
        $this->entityManager = $entityManager;
    }

    public function handle(RegisterPostCommand $postCommand)
    {
        $user = $this->userRepository->find($postCommand->getUserId());
        if ($user === null) {
            throw new UserNotFoundException();
        }

        $post = $this->postFactory->createPostFromCommand($postCommand, $user);

        $this->entityManager->persist($post);
    }
}
