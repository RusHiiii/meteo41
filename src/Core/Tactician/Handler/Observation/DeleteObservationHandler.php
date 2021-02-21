<?php

namespace App\Core\Tactician\Handler\Observation;

use App\Core\Exception\Observation\ObservationNotFoundException;
use App\Core\Tactician\Command\Observation\DeleteObservationCommand;
use App\Repository\Doctrine\ObservationRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteObservationHandler
{
    /**
     * @var ObservationRepository
     */
    private $observationRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * DeleteObservationHandler constructor.
     * @param ObservationRepository $observationRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ObservationRepository $observationRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
        $this->observationRepository = $observationRepository;
    }

    public function handle(DeleteObservationCommand $command)
    {
        $observation = $this->observationRepository->find($command->getId());
        if ($observation === null) {
            throw new ObservationNotFoundException();
        }

        $this->entityManager->remove($observation);
    }
}
