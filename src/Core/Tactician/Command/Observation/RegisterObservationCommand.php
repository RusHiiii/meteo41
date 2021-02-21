<?php

namespace App\Core\Tactician\Command\Observation;

class RegisterObservationCommand
{
    private string $message;

    private int $userId;

    private int $weatherStationId;

    /**
     * RegisterObservationCommand constructor.
     * @param string $message
     * @param int $weatherStationId
     */
    public function __construct(string $message, int $weatherStationId)
    {
        $this->message = $message;
        $this->weatherStationId = $weatherStationId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getWeatherStationId(): int
    {
        return $this->weatherStationId;
    }
}
