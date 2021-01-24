<?php

namespace App\Core\Tactician\Handler\User;

use App\Core\Exception\User\BadPasswordConfirmationException;
use App\Core\Exception\User\BadPasswordSecurityException;
use App\Core\Exception\User\RoleNotFoundException;
use App\Core\Exception\User\UserAlreadyExistException;
use App\Core\Factory\UserFactory;
use App\Core\Tactician\Command\User\RegisterUserCommand;
use App\Entity\WebApp\User;
use App\Repository\Doctrine\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class RegisterUserHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        UserRepository $userRepository,
        UserFactory $userFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
        $this->entityManager = $entityManager;
    }

    public function handle(RegisterUserCommand $registerUserCommand)
    {
        $user = $this->userRepository->findByEmail($registerUserCommand->getEmail());
        if ($user !== null) {
            throw new UserAlreadyExistException();
        }

        if ($registerUserCommand->getPassword() !== $registerUserCommand->getPasswordConfirmation()) {
            throw new BadPasswordConfirmationException();
        }

        if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$*%]{8,15}$/', $registerUserCommand->getPassword())) {
            throw new BadPasswordSecurityException();
        }

        if (count(array_intersect(User::EXISTING_ROLES, $registerUserCommand->getRoles())) != count($registerUserCommand->getRoles())) {
            throw new RoleNotFoundException();
        }

        $user = $this->userFactory->createUserFromCommand($registerUserCommand);
        $this->entityManager->persist($user);
    }
}
