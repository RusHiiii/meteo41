<?php

namespace App\Core\Factory;

use App\Core\Tactician\Command\WeatherStation\EditWeatherStationCommand;
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

    /**
     * @param WeatherStation $weatherStation
     * @param EditWeatherStationCommand $command
     * @return WeatherStation
     */
    public function editWeatherStationFromCommand(WeatherStation $weatherStation, EditWeatherStationCommand $command)
    {
        $weatherStation->setName($command->getName());
        $weatherStation->setDescription($command->getDescription());
        $weatherStation->setShortDescription($command->getShortDescription());
        $weatherStation->setCountry($command->getCountry());
        $weatherStation->setAddress($command->getAddress());
        $weatherStation->setCity($command->getCity());
        $weatherStation->setLat($command->getLat());
        $weatherStation->setLng($command->getLng());
        $weatherStation->setApiToken($command->getApiToken());
        $weatherStation->setModel($command->getModel());
        $weatherStation->setElevation($command->getElevation());

        return $weatherStation;
    }
}
