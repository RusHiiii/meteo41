<?php

namespace App\Core\Factory;

use App\Core\Tactician\Command\WeatherStation\RegisterWeatherStationCommand;
use App\Entity\WebApp\WeatherStation;

class WeatherStationFactory
{
    /**
     * @param RegisterWeatherStationCommand $command
     * @return WeatherStation
     */
    public function createWeatherStationFromCommand(RegisterWeatherStationCommand $command)
    {
        return new WeatherStation(
            $command->getName(),
            $command->getDescription(),
            $command->getShortDescription(),
            $command->getCountry(),
            $command->getAddress(),
            $command->getCity(),
            $command->getLat(),
            $command->getLng(),
            $command->getApiToken(),
            $command->getModel(),
            $command->getElevation()
        );
    }
}
