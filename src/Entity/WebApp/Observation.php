<?php

namespace App\Entity\WebApp;

class Observation
{
    private int $id;

    private string $message;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    private User $user;

    private WeatherStation $weatherStation;

    /**
     * Observation constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
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
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return WeatherStation
     */
    public function getWeatherStation(): WeatherStation
    {
        return $this->weatherStation;
    }

    /**
     * @param WeatherStation $weatherStation
     */
    public function setWeatherStation(WeatherStation $weatherStation): void
    {
        $this->weatherStation = $weatherStation;
    }
}
