<?php

namespace App\Entity\Core\ViewModels\WeatherData;

use App\Entity\Core\ViewModels\Unit\UnitView;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationView;

class WeatherDataGraphView
{
    private int $id;

    private float $temperature;

    private ?float $soilTemperature;

    private int $humidity;

    private ?int $leafWetness;

    private float $relativePressure;

    private int $windDirection;

    private float $windSpeed;

    private float $windGust;

    private float $rainRate;

    private float $rainDaily;

    private float $solarRadiation;

    private int $uv;

    private int $pm25;

    private float $dewPoint;

    private float $windChill;

    private int $aqi;

    private int $aqiAvg;

    private \DateTime $receivedAt;

    /**
     * WeatherDataGraphView constructor.
     * @param int $id
     * @param float $temperature
     * @param int $humidity
     * @param float $relativePressure
     * @param int $windDirection
     * @param float $windSpeed
     * @param float $windGust
     * @param float $rainRate
     * @param float $rainDaily
     * @param float $solarRadiation
     * @param int $uv
     * @param int $pm25
     * @param float $dewPoint
     * @param float $windChill
     * @param int $aqi
     * @param int $aqiAvg
     * @param float|null $soilTemperature
     * @param int|null $leafWetness
     * @param \DateTime $receivedAt
     */
    public function __construct(int $id, float $temperature, int $humidity, float $relativePressure, int $windDirection, float $windSpeed, float $windGust, float $rainRate, float $rainDaily, float $solarRadiation, int $uv, int $pm25, float $dewPoint, float $windChill, int $aqi, int $aqiAvg, ?float $soilTemperature, ?int $leafWetness, \DateTime $receivedAt)
    {
        $this->id = $id;
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->relativePressure = $relativePressure;
        $this->windDirection = $windDirection;
        $this->windSpeed = $windSpeed;
        $this->windGust = $windGust;
        $this->rainRate = $rainRate;
        $this->rainDaily = $rainDaily;
        $this->solarRadiation = $solarRadiation;
        $this->uv = $uv;
        $this->pm25 = $pm25;
        $this->dewPoint = $dewPoint;
        $this->windChill = $windChill;
        $this->aqi = $aqi;
        $this->aqiAvg = $aqiAvg;
        $this->leafWetness = $leafWetness;
        $this->soilTemperature = $soilTemperature;
        $this->receivedAt = $receivedAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @return int
     */
    public function getHumidity(): int
    {
        return $this->humidity;
    }

    /**
     * @return float|null
     */
    public function getSoilTemperature(): ?float
    {
        return $this->soilTemperature;
    }

    /**
     * @return int|null
     */
    public function getLeafWetness(): ?int
    {
        return $this->leafWetness;
    }

    /**
     * @return float
     */
    public function getRelativePressure(): float
    {
        return $this->relativePressure;
    }

    /**
     * @return int
     */
    public function getWindDirection(): int
    {
        return $this->windDirection;
    }

    /**
     * @return float
     */
    public function getWindSpeed(): float
    {
        return $this->windSpeed;
    }

    /**
     * @return float
     */
    public function getWindGust(): float
    {
        return $this->windGust;
    }

    /**
     * @return float
     */
    public function getRainRate(): float
    {
        return $this->rainRate;
    }

    /**
     * @return float
     */
    public function getRainDaily(): float
    {
        return $this->rainDaily;
    }

    /**
     * @return float
     */
    public function getSolarRadiation(): float
    {
        return $this->solarRadiation;
    }

    /**
     * @return int
     */
    public function getUv(): int
    {
        return $this->uv;
    }

    /**
     * @return int
     */
    public function getPm25(): int
    {
        return $this->pm25;
    }

    /**
     * @return float
     */
    public function getDewPoint(): float
    {
        return $this->dewPoint;
    }

    /**
     * @return float
     */
    public function getWindChill(): float
    {
        return $this->windChill;
    }

    /**
     * @return int
     */
    public function getAqi(): int
    {
        return $this->aqi;
    }

    /**
     * @return int
     */
    public function getAqiAvg(): int
    {
        return $this->aqiAvg;
    }

    /**
     * @return \DateTime
     */
    public function getReceivedAt(): \DateTime
    {
        return $this->receivedAt;
    }
}
