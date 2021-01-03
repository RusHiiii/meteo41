<?php

namespace App\Core\Tactician\Handler\WeatherStation;

use App\Core\Exception\WeatherStation\DuplicateWeatherStationFoundException;
use App\Core\Exception\WeatherStation\WeatherStationNotFoundException;
use App\Core\Factory\WeatherStationFactory;
use App\Core\Tactician\Command\WeatherStation\EditWeatherStationCommand;
use App\Core\Tactician\Command\WeatherStation\RegisterWeatherStationCommand;
use App\Repository\Doctrine\WeatherStationRepository;
use Doctrine\ORM\EntityManagerInterface;

class EditWeatherStationHandler
{
    /**
     * @var WeatherStationRepository
     */
    private $weatherStationRepository;

    /**
     * @var WeatherStationFactory
     */
    private $weatherStationFactory;

    public function __construct(
        WeatherStationRepository $weatherStationRepository,
        WeatherStationFactory $weatherStationFactory
    ) {
        $this->weatherStationRepository = $weatherStationRepository;
        $this->weatherStationFactory = $weatherStationFactory;
    }


    public function handle(EditWeatherStationCommand $command)
    {
        $station = $this->weatherStationRepository->find($command->getId());
        if ($station === null) {
            throw new WeatherStationNotFoundException();
        }

        $weatherStation = $this->weatherStationFactory->editWeatherStationFromCommand($station, $command);
    }
}
