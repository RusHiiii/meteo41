<?php

namespace App\Core\Tactician\Handler\WeatherStation;

use App\Core\Exception\Unit\UnitNotFoundException;
use App\Core\Exception\WeatherStation\DuplicateWeatherStationFoundException;
use App\Core\Factory\WeatherStationFactory;
use App\Core\Tactician\Command\WeatherStation\RegisterWeatherStationCommand;
use App\Repository\Doctrine\UnitRepository;
use App\Repository\Doctrine\WeatherStationRepository;
use Doctrine\ORM\EntityManagerInterface;

class RegisterWeatherStationHandler
{
    /**
     * @var WeatherStationRepository
     */
    private $weatherStationRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

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
        EntityManagerInterface $entityManager,
        WeatherStationFactory $weatherStationFactory,
        UnitRepository $unitRepository
    ) {
        $this->weatherStationRepository = $weatherStationRepository;
        $this->entityManager = $entityManager;
        $this->weatherStationFactory = $weatherStationFactory;
        $this->unitRepository = $unitRepository;
    }

    public function handle(RegisterWeatherStationCommand $command)
    {
        $stations = $this->weatherStationRepository->findDuplicated($command->getCountry(), $command->getAddress(), $command->getCity());
        if (count($stations) > 0) {
            throw new DuplicateWeatherStationFoundException();
        }

        $unit = $this->unitRepository->findByType($command->getPreferedUnit());
        if ($unit === null) {
            throw new UnitNotFoundException();
        }

        $weatherStation = $this->weatherStationFactory->createWeatherStationFromCommand($command, $unit);

        $this->entityManager->persist($weatherStation);
    }
}
