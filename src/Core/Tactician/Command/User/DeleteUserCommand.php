<?php

namespace App\Core\Tactician\Command\User;

class DeleteUserCommand
{
    private int $id;

    /**
     * DeleteUserCommand constructor.
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
