<?php

namespace App\Core\Tactician\Handler\User;

use App\Core\Exception\User\BadPasswordConfirmationException;
use App\Core\Exception\User\CannotEditMailException;
use App\Core\Exception\User\RoleNotFoundException;
use App\Core\Exception\User\UserNotFoundException;
use App\Core\Factory\UserFactory;
use App\Core\Tactician\Command\User\EditUserCommand;
use App\Entity\WebApp\User;
use App\Repository\Doctrine\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class EditUserHandler
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

    public function handle(EditUserCommand $editUserCommand)
    {
        $user = $this->userRepository->find($editUserCommand->getId());
        if ($user === null) {
            throw new UserNotFoundException();
        }

        if ($user->getEmail() !== $editUserCommand->getEmail()) {
            throw new CannotEditMailException();
        }

        if ($editUserCommand->getPassword() !== $editUserCommand->getPasswordConfirmation()) {
            throw new BadPasswordConfirmationException();
        }

        if (count(array_intersect(User::EXISTING_ROLES, $editUserCommand->getRoles())) != count($editUserCommand->getRoles())) {
            throw new RoleNotFoundException();
        }

        $user = $this->userFactory->editUserFromCommand($user, $editUserCommand);
    }
}
