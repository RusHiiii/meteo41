<?php

namespace App\Core\Tactician\Command\Post;

class EditPostCommand extends RegisterPostCommand
{
    private int $id;

    /**
     * EditPostCommand constructor.
     * @param string $name
     * @param string $description
     */
    public function __construct(string $name, string $description)
    {
        parent::__construct($name, $description);
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
