<?php

namespace App\Core\Factory;

use App\Core\Tactician\Command\Unit\EditUnitCommand;
use App\Core\Tactician\Command\Unit\RegisterUnitCommand;
use App\Entity\WebApp\Unit;

class UnitFactory
{

    /**
     * @param RegisterUnitCommand $command
     * @return Unit
     */
    public function createUnitFromCommand(RegisterUnitCommand $command)
    {
        return new Unit(
            $command->getTemperatureUnit(),
            $command->getSpeedUnit(),
            $command->getRainUnit(),
            $command->getSolarRadiationUnit(),
            $command->getPmUnit(),
            $command->getHumidityUnit(),
            $command->getType(),
            $command->getCloudBaseUnit(),
            $command->getWindDirUnit(),
            $command->getPressureUnit()
        );
    }

    /**
     * @param Unit $unit
     * @param EditUnitCommand $command
     * @return Unit
     */
    public function editUnitFromCommand(Unit $unit, EditUnitCommand $command)
    {
        $unit->setHumidityUnit($command->getHumidityUnit());
        $unit->setPmUnit($command->getPmUnit());
        $unit->setRainUnit($command->getRainUnit());
        $unit->setSolarRadiationUnit($command->getSolarRadiationUnit());
        $unit->setSpeedUnit($command->getSpeedUnit());
        $unit->setTemperatureUnit($command->getTemperatureUnit());
        $unit->setCloudBaseUnit($command->getCloudBaseUnit());
        $unit->setWindDirUnit($command->getWindDirUnit());
        $unit->setPressureUnit($command->getPressureUnit());
        $unit->setType($command->getType());
        $unit->setUpdatedAt(new \DateTime());

        return $unit;
    }
}
