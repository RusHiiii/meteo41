<?php

namespace App\Core\Tactician\Handler\Unit;

use App\Core\Exception\Unit\UnitNotFoundException;
use App\Core\Factory\UnitFactory;
use App\Core\Tactician\Command\Unit\EditUnitCommand;
use App\Repository\Doctrine\UnitRepository;
use Doctrine\ORM\EntityManagerInterface;

class EditUnitHandler
{
    /**
     * @var UnitRepository
     */
    private $unitRepository;

    /**
     * @var UnitFactory
     */
    private $unitFactory;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        UnitRepository $unitRepository,
        UnitFactory $unitFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->unitRepository = $unitRepository;
        $this->unitFactory = $unitFactory;
        $this->entityManager = $entityManager;
    }

    public function handle(EditUnitCommand $command)
    {
        $unit = $this->unitRepository->find($command->getId());
        if ($unit === null) {
            throw new UnitNotFoundException();
        }

        $unit = $this->unitFactory->editUnitFromCommand($unit, $command);
    }
}
