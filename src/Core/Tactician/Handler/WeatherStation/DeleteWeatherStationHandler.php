<?php

namespace App\Core\Tactician\Handler\WeatherStation;

use App\Core\Exception\WeatherStation\WeatherStationNotFoundException;
use App\Core\Tactician\Command\WeatherStation\DeleteWeatherStationCommand;
use App\Repository\Doctrine\WeatherStationRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteWeatherStationHandler
{
    /**
     * @var WeatherStationRepository
     */
    private $weatherStationRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        WeatherStationRepository $weatherStationRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->weatherStationRepository = $weatherStationRepository;
        $this->entityManager = $entityManager;
    }


    public function handle(DeleteWeatherStationCommand $command)
    {
        $weatherStation = $this->weatherStationRepository->find($command->getId());
        if ($weatherStation === null) {
            throw new WeatherStationNotFoundException();
        }

        $this->entityManager->remove($weatherStation);
    }
}
