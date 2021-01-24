<?php

namespace App\Core\Tactician\Command\User;

class EditUserCommand extends RegisterUserCommand
{
    private $id;

    /**
     * EditUserCommand constructor.
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     * @param array $roles
     */
    public function __construct(string $firstname, string $lastname, string $email, string $password, string $passwordConfirmation, array $roles = [])
    {
        parent::__construct($firstname, $lastname, $email, $password, $passwordConfirmation, $roles);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
}
