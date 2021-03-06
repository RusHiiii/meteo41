<?php

namespace App\Core\Tactician\Command\Post;

class DeletePostCommand
{
    private int $id;

    /**
     * DeletePostCommand constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
