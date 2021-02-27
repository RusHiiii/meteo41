<?php

namespace App\Core\Tactician\Handler\WeatherData;

use App\Core\Exception\WeatherStation\WeatherStationNotFoundException;
use App\Core\Tactician\Command\WeatherData\RegisterWeatherDataCommand;
use App\Repository\Doctrine\WeatherStationRepository;
use Doctrine\ORM\EntityManagerInterface;

class RegisterWeatherDataHandler
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
     * RegisterWeatherDataHandler constructor.
     * @param WeatherStationRepository $weatherStationRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        WeatherStationRepository $weatherStationRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->weatherStationRepository = $weatherStationRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(RegisterWeatherDataCommand $command)
    {
        $weatherStation = $this->weatherStationRepository->find($command->getWeatherStationId());
        if ($weatherStation === null) {
            throw new WeatherStationNotFoundException();
        }

        // Calcul des données
        //TODO

        // Conversion si besoin
        //TODO

        // Persist + Assembler
        //TODO
    }
}
