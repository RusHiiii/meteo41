<?php


namespace App\Entity\Core\ViewModels\Post;


use App\Entity\Core\ViewModels\User\UserView;

class PostView
{
    private int $id;

    private string $name;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    private string $description;

    private UserView $user;

    /**
     * PostView constructor.
     * @param int $id
     * @param string $name
     * @param \DateTime $createdAt
     * @param \DateTime $updatedAt
     * @param string $description
     * @param UserView $user
     */
    public function __construct(int $id, string $name, \DateTime $createdAt, \DateTime $updatedAt, string $description, UserView $user)
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->description = $description;
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return UserView
     */
    public function getUser(): UserView
    {
        return $this->user;
    }
}