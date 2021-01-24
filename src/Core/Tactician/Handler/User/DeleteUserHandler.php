<?php

namespace App\Core\Tactician\Handler\User;

use App\Core\Exception\User\UserNotFoundException;
use App\Core\Tactician\Command\User\DeleteUserCommand;
use App\Repository\Doctrine\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteUserHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(DeleteUserCommand $deleteUserCommand)
    {
        $user = $this->userRepository->find($deleteUserCommand->getId());
        if ($user === null) {
            throw new UserNotFoundException();
        }

        $this->entityManager->remove($user);
    }
}
