<?php

namespace App\Core\Tactician\Handler\WeatherStation;

use App\Core\Exception\WeatherStation\DuplicateWeatherStationFoundException;
use App\Core\Factory\WeatherStationFactory;
use App\Core\Tactician\Command\WeatherStation\RegisterWeatherStationCommand;
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

    public function __construct(
        WeatherStationRepository $weatherStationRepository,
        EntityManagerInterface $entityManager,
        WeatherStationFactory $weatherStationFactory
    ) {
        $this->weatherStationRepository = $weatherStationRepository;
        $this->entityManager = $entityManager;
        $this->weatherStationFactory = $weatherStationFactory;
    }


    public function handle(RegisterWeatherStationCommand $command)
    {
        $stations = $this->weatherStationRepository->findDuplicated($command->getCountry(), $command->getAddress(), $command->getCity());
        if (count($stations) > 0) {
            throw new DuplicateWeatherStationFoundException();
        }

        $weatherStation = $this->weatherStationFactory->createWeatherStationFromCommand($command);

        $this->entityManager->persist($weatherStation);
    }
}
