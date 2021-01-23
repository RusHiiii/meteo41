<?php

namespace App\Core\Factory;

use App\Core\Tactician\Command\User\EditUserCommand;
use App\Core\Tactician\Command\User\RegisterUserCommand;
use App\Entity\WebApp\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactory
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFactory constructor.
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param RegisterUserCommand $registerUserCommand
     * @return User
     */
    public function createUserFromCommand(RegisterUserCommand $registerUserCommand)
    {
        $user = new User(
            $registerUserCommand->getFirstname(),
            $registerUserCommand->getLastname(),
            $registerUserCommand->getEmail()
        );

        $encodedPassword = $this->passwordEncoder->encodePassword($user, $registerUserCommand->getPassword());
        $user->setPassword($encodedPassword);

        $user->setRoles($registerUserCommand->getRoles());

        return $user;
    }

    /**
     * @param User $user
     * @param EditUserCommand $editUserCommand
     * @return User
     */
    public function editUserFromCommand(User $user, EditUserCommand $editUserCommand)
    {
        $user->setFirstname($editUserCommand->getFirstname());
        $user->setLastname($editUserCommand->getLastname());
        $user->setRoles($editUserCommand->getRoles());

        $encodedPassword = $this->passwordEncoder->encodePassword($user, $editUserCommand->getPassword());
        $user->setPassword($encodedPassword);

        return $user;
    }
}
