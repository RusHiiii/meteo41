<?php

namespace App\Core\Tactician\Command\Contact;

class EditContactCommand extends RegisterContactCommand
{
    private int $id;

    /**
     * EditContactCommand constructor.
     * @param string $name
     * @param string $email
     * @param string $subject
     * @param string $message
     */
    public function __construct(string $name, string $email, string $subject, string $message)
    {
        parent::__construct($name, $email, $subject, $message);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
