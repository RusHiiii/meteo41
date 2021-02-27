<?php

namespace App\Core\Tactician\Handler\WeatherStation;

use App\Core\Exception\Unit\UnitNotFoundException;
use App\Core\Exception\WeatherStation\DuplicateWeatherStationFoundException;
use App\Core\Exception\WeatherStation\WeatherStationNotFoundException;
use App\Core\Factory\WeatherStationFactory;
use App\Core\Tactician\Command\WeatherStation\EditWeatherStationCommand;
use App\Core\Tactician\Command\WeatherStation\RegisterWeatherStationCommand;
use App\Repository\Doctrine\UnitRepository;
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

    /**
     * @var UnitRepository
     */
    private $unitRepository;

    public function __construct(
        WeatherStationRepository $weatherStationRepository,
        WeatherStationFactory $weatherStationFactory,
        UnitRepository $unitRepository
    ) {
        $this->weatherStationRepository = $weatherStationRepository;
        $this->weatherStationFactory = $weatherStationFactory;
        $this->unitRepository = $unitRepository;
    }

    public function handle(EditWeatherStationCommand $command)
    {
        $station = $this->weatherStationRepository->find($command->getId());
        if ($station === null) {
            throw new WeatherStationNotFoundException();
        }

        $unit = $this->unitRepository->find($command->getPreferedUnitId());
        if ($unit === null) {
            throw new UnitNotFoundException();
        }

        $weatherStation = $this->weatherStationFactory->editWeatherStationFromCommand($station, $command, $unit);
    }
}
