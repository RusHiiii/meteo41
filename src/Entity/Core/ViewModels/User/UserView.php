<?php

namespace App\Entity\Core\ViewModels\User;

class UserView
{
    private int $id;

    private string $firstname;

    private string $lastname;

    private ?string $email;

    private ?array $roles;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    /**
     * UserView constructor.
     * @param int $id
     * @param string $firstname
     * @param string $lastname
     * @param string|null $email
     * @param array|null $roles
     * @param \DateTime $createdAt
     * @param \DateTime $updatedAt
     */
    public function __construct(int $id, string $firstname, string $lastname, ?string $email, ?array $roles, \DateTime $createdAt, \DateTime $updatedAt)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->roles = $roles;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
