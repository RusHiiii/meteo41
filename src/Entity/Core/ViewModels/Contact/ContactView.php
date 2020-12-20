<?php


namespace App\Entity\Core\ViewModels\Contact;


class ContactView
{
    private int $id;

    private string $name;

    private string $subject;

    private string $email;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    private string $message;

    /**
     * ContactView constructor.
     * @param int $id
     * @param string $name
     * @param string $subject
     * @param string $email
     * @param \DateTime $createdAt
     * @param \DateTime $updatedAt
     * @param string $message
     */
    public function __construct(int $id, string $name, string $subject, string $email, \DateTime $createdAt, \DateTime $updatedAt, string $message)
    {
        $this->id = $id;
        $this->name = $name;
        $this->subject = $subject;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->message = $message;
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
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
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
    public function getMessage(): string
    {
        return $this->message;
    }
}