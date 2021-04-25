<?php

namespace App\Core\Tactician\Command\Unit;

class RegisterUnitCommand
{
    private string $temperatureUnit;

    private string $speedUnit;

    private string $rainUnit;

    private string $pressureUnit;

    private string $solarRadiationUnit;

    private string $cloudBaseUnit;

    private string $windDirUnit;

    private string $pmUnit;

    private string $humidityUnit;

    private string $type;

    /**
     * RegisterUnitCommand constructor.
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
        $this->temperatureUnit = $temperatureUnit;
        $this->speedUnit = $speedUnit;
        $this->rainUnit = $rainUnit;
        $this->solarRadiationUnit = $solarRadiationUnit;
        $this->pmUnit = $pmUnit;
        $this->humidityUnit = $humidityUnit;
        $this->cloudBaseUnit = $cloudBaseUnit;
        $this->windDirUnit = $windDirUnit;
        $this->type = $type;
        $this->pressureUnit = $pressureUnit;
    }

    /**
     * @return string
     */
    public function getTemperatureUnit(): string
    {
        return $this->temperatureUnit;
    }

    /**
     * @return string
     */
    public function getSpeedUnit(): string
    {
        return $this->speedUnit;
    }

    /**
     * @return string
     */
    public function getRainUnit(): string
    {
        return $this->rainUnit;
    }

    /**
     * @return string
     */
    public function getSolarRadiationUnit(): string
    {
        return $this->solarRadiationUnit;
    }

    /**
     * @return string
     */
    public function getPmUnit(): string
    {
        return $this->pmUnit;
    }

    /**
     * @return string
     */
    public function getHumidityUnit(): string
    {
        return $this->humidityUnit;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getCloudBaseUnit(): string
    {
        return $this->cloudBaseUnit;
    }

    /**
     * @return string
     */
    public function getWindDirUnit(): string
    {
        return $this->windDirUnit;
    }

    /**
     * @return string
     */
    public function getPressureUnit(): string
    {
        return $this->pressureUnit;
    }
}
