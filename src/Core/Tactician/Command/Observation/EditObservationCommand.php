<?php

namespace App\Core\Tactician\Command\Observation;

class EditObservationCommand extends RegisterObservationCommand
{
    private int $id;

    /**
     * EditObservationCommand constructor.
     * @param string $message
     * @param int $weatherStationId
     */
    public function __construct(string $message, int $weatherStationId)
    {
        parent::__construct($message, $weatherStationId);
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
