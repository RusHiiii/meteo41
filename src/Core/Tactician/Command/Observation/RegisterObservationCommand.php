<?php

namespace App\Core\Tactician\Command\Observation;

class RegisterObservationCommand
{
    private string $message;

    private int $userId;

    private string $weatherStation;

    /**
     * RegisterObservationCommand constructor.
     * @param string $message
     * @param string $weatherStation
     */
    public function __construct(string $message, string $weatherStation)
    {
        $this->message = $message;
        $this->weatherStation = $weatherStation;
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
     * @return string
     */
    public function getWeatherStation(): string
    {
        return $this->weatherStation;
    }
}
