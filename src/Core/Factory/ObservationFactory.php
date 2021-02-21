<?php

namespace App\Core\Factory;

use App\Core\Tactician\Command\Observation\EditObservationCommand;
use App\Core\Tactician\Command\Observation\RegisterObservationCommand;
use App\Entity\WebApp\Observation;
use App\Entity\WebApp\User;
use App\Entity\WebApp\WeatherStation;

class ObservationFactory
{
    /**
     * @param RegisterObservationCommand $command
     * @param User $user
     * @param WeatherStation $station
     * @return Observation
     */
    public function createObservationFromCommand(RegisterObservationCommand $command, User $user, WeatherStation $station)
    {
        $observation = new Observation($command->getMessage());

        $observation->setUser($user);
        $observation->setWeatherStation($station);

        return $observation;
    }

    /**
     * @param Observation $observation
     * @param EditObservationCommand $command
     * @param WeatherStation $weatherStation
     * @return Observation
     */
    public function editObservationFromCommand(Observation $observation, EditObservationCommand $command, WeatherStation $weatherStation)
    {
        $observation->setMessage($command->getMessage());
        $observation->setUpdatedAt(new \DateTime());
        $observation->setWeatherStation($weatherStation);

        return $observation;
    }
}
