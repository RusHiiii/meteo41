<?php

namespace App\Core\Tactician\Command\Unit;

class DeleteUnitCommand
{
    private int $id;

    /**
     * DeleteUnitCommand constructor.
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
