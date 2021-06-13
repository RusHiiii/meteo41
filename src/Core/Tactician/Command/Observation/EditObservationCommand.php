<?php

namespace App\Core\Tactician\Command\Observation;

class EditObservationCommand extends RegisterObservationCommand
{
    private int $id;

    /**
     * EditObservationCommand constructor.
     * @param string $message
     * @param string $weatherStation
     */
    public function __construct(string $message, string $weatherStation)
    {
        parent::__construct($message, $weatherStation);
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
