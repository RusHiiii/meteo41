<?php

namespace App\Entity\Core\ViewModels\Observation;

use App\Entity\Core\ViewModels\User\UserView;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationView;

class ObservationView
{
    private int $id;

    private string $message;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    private UserView $user;

    private WeatherStationView $weatherStation;

    /**
     * ObservationView constructor.
     * @param int $id
     * @param string $message
     * @param \DateTime $createdAt
     * @param \DateTime $updatedAt
     * @param UserView $user
     * @param WeatherStationView $weatherStation
     */
    public function __construct(int $id, string $message, \DateTime $createdAt, \DateTime $updatedAt, UserView $user, WeatherStationView $weatherStation)
    {
        $this->id = $id;
        $this->message = $message;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->user = $user;
        $this->weatherStation = $weatherStation;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return UserView
     */
    public function getUser(): UserView
    {
        return $this->user;
    }

    /**
     * @return WeatherStationView
     */
    public function getWeatherStation(): WeatherStationView
    {
        return $this->weatherStation;
    }
}
