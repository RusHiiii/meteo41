<?php

namespace App\Core\Tactician\Command\Observation;

class DeleteObservationCommand
{
    private int $id;

    /**
     * DeleteObservationCommand constructor.
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
