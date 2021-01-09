<?php

namespace App\Core\Tactician\Handler\Unit;

use App\Core\Exception\Unit\UnitNotFoundException;
use App\Core\Tactician\Command\Unit\DeleteUnitCommand;
use App\Repository\Doctrine\UnitRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteUnitHandler
{
    /**
     * @var UnitRepository
     */
    private $unitRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        UnitRepository $unitRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->unitRepository = $unitRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(DeleteUnitCommand $command)
    {
        $unit = $this->unitRepository->find($command->getId());
        if ($unit === null) {
            throw new UnitNotFoundException();
        }

        $this->entityManager->remove($unit);
    }
}
