<?php

namespace App\Entity\WebApp;

class Unit
{
    const UNIT_METRIC = 'Metric';
    const UNIT_IMPERIAL = 'Imperial';

    private int $id;

    private string $temperatureUnit;

    private string $speedUnit;

    private string $rainUnit;

    private string $pressureUnit;

    private string $solarRadiationUnit;

    private string $pmUnit;

    private string $humidityUnit;

    private string $cloudBaseUnit;

    private string $windDirUnit;

    private string $type;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    /**
     * Unit constructor.
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
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTemperatureUnit(): string
    {
        return $this->temperatureUnit;
    }

    /**
     * @param string $temperatureUnit
     */
    public function setTemperatureUnit(string $temperatureUnit): void
    {
        $this->temperatureUnit = $temperatureUnit;
    }

    /**
     * @return string
     */
    public function getSpeedUnit(): string
    {
        return $this->speedUnit;
    }

    /**
     * @param string $speedUnit
     */
    public function setSpeedUnit(string $speedUnit): void
    {
        $this->speedUnit = $speedUnit;
    }

    /**
     * @return string
     */
    public function getRainUnit(): string
    {
        return $this->rainUnit;
    }

    /**
     * @param string $rainUnit
     */
    public function setRainUnit(string $rainUnit): void
    {
        $this->rainUnit = $rainUnit;
    }

    /**
     * @return string
     */
    public function getSolarRadiationUnit(): string
    {
        return $this->solarRadiationUnit;
    }

    /**
     * @param string $solarRadiationUnit
     */
    public function setSolarRadiationUnit(string $solarRadiationUnit): void
    {
        $this->solarRadiationUnit = $solarRadiationUnit;
    }

    /**
     * @return string
     */
    public function getPmUnit(): string
    {
        return $this->pmUnit;
    }

    /**
     * @param string $pmUnit
     */
    public function setPmUnit(string $pmUnit): void
    {
        $this->pmUnit = $pmUnit;
    }

    /**
     * @return string
     */
    public function getHumidityUnit(): string
    {
        return $this->humidityUnit;
    }

    /**
     * @param string $humidityUnit
     */
    public function setHumidityUnit(string $humidityUnit): void
    {
        $this->humidityUnit = $humidityUnit;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getCloudBaseUnit(): string
    {
        return $this->cloudBaseUnit;
    }

    /**
     * @param string $cloudBaseUnit
     */
    public function setCloudBaseUnit(string $cloudBaseUnit): void
    {
        $this->cloudBaseUnit = $cloudBaseUnit;
    }

    /**
     * @return string
     */
    public function getWindDirUnit(): string
    {
        return $this->windDirUnit;
    }

    /**
     * @param string $windDirUnit
     */
    public function setWindDirUnit(string $windDirUnit): void
    {
        $this->windDirUnit = $windDirUnit;
    }

    /**
     * @return string
     */
    public function getPressureUnit(): string
    {
        return $this->pressureUnit;
    }

    /**
     * @param string $pressureUnit
     */
    public function setPressureUnit(string $pressureUnit): void
    {
        $this->pressureUnit = $pressureUnit;
    }
}
