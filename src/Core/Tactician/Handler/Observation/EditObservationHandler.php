<?php

namespace App\Core\Tactician\Handler\Observation;

use App\Core\Exception\Observation\ObservationMessageRequiredException;
use App\Core\Exception\Observation\ObservationNotFoundException;
use App\Core\Exception\WeatherStation\WeatherStationNotFoundException;
use App\Core\Factory\ObservationFactory;
use App\Core\Tactician\Command\Observation\EditObservationCommand;
use App\Repository\Doctrine\ObservationRepository;
use App\Repository\Doctrine\UserRepository;
use App\Repository\Doctrine\WeatherStationRepository;
use Doctrine\ORM\EntityManagerInterface;

class EditObservationHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var WeatherStationRepository
     */
    private $weatherStationRepository;

    /**
     * @var ObservationFactory
     */
    private $observationFactory;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ObservationRepository
     */
    private $observationRepository;

    /**
     * RegisterObservationHandler constructor.
     * @param UserRepository $userRepository
     * @param WeatherStationRepository $weatherStationRepository
     * @param ObservationFactory $observationFactory
     * @param EntityManagerInterface $entityManager
     * @param ObservationRepository $observationRepository
     */
    public function __construct(
        UserRepository $userRepository,
        WeatherStationRepository $weatherStationRepository,
        ObservationFactory $observationFactory,
        EntityManagerInterface $entityManager,
        ObservationRepository $observationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->weatherStationRepository = $weatherStationRepository;
        $this->observationFactory = $observationFactory;
        $this->entityManager = $entityManager;
        $this->observationRepository = $observationRepository;
    }

    public function handle(EditObservationCommand $command)
    {
        $observation = $this->observationRepository->find($command->getId());
        if ($observation === null) {
            throw new ObservationNotFoundException();
        }

        $weatherStation = $this->weatherStationRepository->findByReference($command->getWeatherStation());
        if ($weatherStation === null) {
            throw new WeatherStationNotFoundException();
        }

        if (empty($command->getMessage())) {
            throw new ObservationMessageRequiredException();
        }

        $observation = $this->observationFactory->editObservationFromCommand($observation, $command, $weatherStation);
    }
}
