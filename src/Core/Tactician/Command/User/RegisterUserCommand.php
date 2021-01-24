<?php

namespace App\Core\Tactician\Command\User;

class RegisterUserCommand
{
    private string $firstname;

    private string $lastname;

    private string $email;

    private string $password;

    private string $passwordConfirmation;

    private array $roles;

    /**
     * RegisterUserCommand constructor.
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     * @param array $roles
     */
    public function __construct(string $firstname, string $lastname, string $email, string $password, string $passwordConfirmation, array $roles = [])
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPasswordConfirmation(): string
    {
        return $this->passwordConfirmation;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}
