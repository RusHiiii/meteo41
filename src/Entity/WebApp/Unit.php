<?php


namespace App\Entity\WebApp;


class Unit
{
    private int $id;

    private string $temperatureUnit;

    private string $speedUnit;

    private string $rainUnit;

    private string $solarRadiationUnit;

    private string $pmUnit;

    private string $humidityUnit;

    private string $type;

    private \DateTime $createdAt;

    /**
     * Unit constructor.
     * @param string $temperatureUnit
     * @param string $speedUnit
     * @param string $rainUnit
     * @param string $solarRadiationUnit
     * @param string $pmUnit
     * @param string $humidityUnit
     * @param string $type
     */
    public function __construct(string $temperatureUnit, string $speedUnit, string $rainUnit, string $solarRadiationUnit, string $pmUnit, string $humidityUnit, string $type)
    {
        $this->temperatureUnit = $temperatureUnit;
        $this->speedUnit = $speedUnit;
        $this->rainUnit = $rainUnit;
        $this->solarRadiationUnit = $solarRadiationUnit;
        $this->pmUnit = $pmUnit;
        $this->humidityUnit = $humidityUnit;
        $this->type = $type;
        $this->createdAt = new \DateTime();
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
}