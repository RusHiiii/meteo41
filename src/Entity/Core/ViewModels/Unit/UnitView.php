<?php

namespace App\Entity\Core\ViewModels\Unit;

class UnitView
{
    private int $id;

    private string $temperatureUnit;

    private string $speedUnit;

    private string $rainUnit;

    private string $solarRadiationUnit;

    private string $pmUnit;

    private string $humidityUnit;

    private string $cloudBaseUnit;

    private string $windDirUnit;

    private string $type;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    /**
     * UnitView constructor.
     * @param int $id
     * @param string $temperatureUnit
     * @param string $speedUnit
     * @param string $rainUnit
     * @param string $solarRadiationUnit
     * @param string $pmUnit
     * @param string $humidityUnit
     * @param string $type
     * @param string $cloudBaseUnit
     * @param string $windDirUnit
     * @param \DateTime $createdAt
     * @param \DateTime $updatedAt
     */
    public function __construct(int $id, string $temperatureUnit, string $speedUnit, string $rainUnit, string $solarRadiationUnit, string $pmUnit, string $humidityUnit, string $type, string $cloudBaseUnit, string $windDirUnit, \DateTime $createdAt, \DateTime $updatedAt)
    {
        $this->id = $id;
        $this->temperatureUnit = $temperatureUnit;
        $this->speedUnit = $speedUnit;
        $this->rainUnit = $rainUnit;
        $this->solarRadiationUnit = $solarRadiationUnit;
        $this->pmUnit = $pmUnit;
        $this->humidityUnit = $humidityUnit;
        $this->type = $type;
        $this->cloudBaseUnit = $cloudBaseUnit;
        $this->windDirUnit = $windDirUnit;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
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
}
