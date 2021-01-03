<?php

namespace App\Core\Tactician\Command\WeatherStation;

class DeleteWeatherStationCommand
{
    private int $id;

    /**
     * DeleteWeatherStationCommand constructor.
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
