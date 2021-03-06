<?php

namespace App\Core\Tactician\Handler\Unit;

use App\Core\Exception\Unit\InvalidUnitTypeException;
use App\Core\Exception\Unit\UnitAlreadyExistException;
use App\Core\Factory\UnitFactory;
use App\Core\Tactician\Command\Unit\RegisterUnitCommand;
use App\Entity\WebApp\Unit;
use App\Repository\Doctrine\UnitRepository;
use Doctrine\ORM\EntityManagerInterface;

class RegisterUnitHandler
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

    public function handle(RegisterUnitCommand $command)
    {
        $unit = $this->unitRepository->findByType($command->getType());
        if ($unit !== null) {
            throw new UnitAlreadyExistException();
        }

        if (!in_array($command->getType(), [Unit::UNIT_IMPERIAL, Unit::UNIT_METRIC])) {
            throw new InvalidUnitTypeException();
        }

        $unit = $this->unitFactory->createUnitFromCommand($command);

        $this->entityManager->persist($unit);
    }
}
