<?php

namespace App\Core\Tactician\Handler\Observation;

use App\Core\Exception\Observation\ObservationMessageRequiredException;
use App\Core\Exception\User\UserNotFoundException;
use App\Core\Exception\WeatherStation\WeatherStationNotFoundException;
use App\Core\Factory\ObservationFactory;
use App\Core\Tactician\Command\Observation\RegisterObservationCommand;
use App\Repository\Doctrine\UserRepository;
use App\Repository\Doctrine\WeatherStationRepository;
use Doctrine\ORM\EntityManagerInterface;

class RegisterObservationHandler
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
     * RegisterObservationHandler constructor.
     * @param UserRepository $userRepository
     * @param WeatherStationRepository $weatherStationRepository
     * @param ObservationFactory $observationFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        UserRepository $userRepository,
        WeatherStationRepository $weatherStationRepository,
        ObservationFactory $observationFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->weatherStationRepository = $weatherStationRepository;
        $this->observationFactory = $observationFactory;
        $this->entityManager = $entityManager;
    }

    public function handle(RegisterObservationCommand $command)
    {
        $user = $this->userRepository->find($command->getUserId());
        if ($user === null) {
            throw new UserNotFoundException();
        }

        $weatherStation = $this->weatherStationRepository->find($command->getWeatherStationId());
        if ($weatherStation === null) {
            throw new WeatherStationNotFoundException();
        }

        if (empty($command->getMessage())) {
            throw new ObservationMessageRequiredException();
        }

        $observation = $this->observationFactory->createObservationFromCommand($command, $user, $weatherStation);

        $this->entityManager->persist($observation);
    }
}
