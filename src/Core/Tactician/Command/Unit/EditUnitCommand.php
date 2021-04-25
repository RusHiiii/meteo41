<?php

namespace App\Core\Tactician\Command\Unit;

class EditUnitCommand extends RegisterUnitCommand
{
    private $id;

    /**
     * EditUnitCommand constructor.
     * @param string $temperatureUnit
     * @param string $speedUnit
     * @param string $rainUnit
     * @param string $solarRadiationUnit
     * @param string $pmUnit
     * @param string $humidityUnit
     * @param string $type
     * @param string $cloudBaseUnit
     * @param string $windDirUnit
     * @param string $pressureUnit
     */
    public function __construct(string $temperatureUnit, string $speedUnit, string $rainUnit, string $solarRadiationUnit, string $pmUnit, string $humidityUnit, string $type, string $cloudBaseUnit, string $windDirUnit, string $pressureUnit)
    {
        parent::__construct($temperatureUnit, $speedUnit, $rainUnit, $solarRadiationUnit, $pmUnit, $humidityUnit, $type, $cloudBaseUnit, $windDirUnit, $pressureUnit);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
}
