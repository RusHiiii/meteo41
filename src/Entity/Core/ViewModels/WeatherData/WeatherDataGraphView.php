<?php

namespace App\Entity\Core\ViewModels\WeatherData;

use App\Entity\Core\ViewModels\Unit\UnitView;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationView;

class WeatherDataGraphView
{
    private int $id;

    private float $temperature;

    private int $humidity;

    private float $relativePressure;

    private int $windDirection;

    private float $windSpeed;

    private float $windGust;

    private float $rainRate;

    private float $rainDaily;

    private float $rainWeekly;

    private float $rainMonthly;

    private float $rainYearly;

    private float $solarRadiation;

    private int $uv;

    private int $pm25;

    private float $dewPoint;

    private float $windChill;

    private int $aqi;

    private int $aqiAvg;

    private \DateTime $receivedAt;

    /**
     * WeatherDataGraphItemView constructor.
     * @param int $id
     * @param float $temperature
     * @param int $humidity
     * @param float $relativePressure
     * @param int $windDirection
     * @param float $windSpeed
     * @param float $windGust
     * @param float $rainRate
     * @param float $rainDaily
     * @param float $rainWeekly
     * @param float $rainMonthly
     * @param float $rainYearly
     * @param float $solarRadiation
     * @param int $uv
     * @param int $pm25
     * @param int $pm25Avg
     * @param float $dewPoint
     * @param float $windChill
     * @param int $aqi
     * @param int $aqiAvg
     * @param \DateTime $receivedAt
     */
    public function __construct(int $id, float $temperature, int $humidity, float $relativePressure, int $windDirection, float $windSpeed, float $windGust, float $rainRate, float $rainDaily, float $rainWeekly, float $rainMonthly, float $rainYearly, float $solarRadiation, int $uv, int $pm25, int $pm25Avg, float $dewPoint, float $windChill, int $aqi, int $aqiAvg, \DateTime $receivedAt)
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
        $this->rainWeekly = $rainWeekly;
        $this->rainMonthly = $rainMonthly;
        $this->rainYearly = $rainYearly;
        $this->solarRadiation = $solarRadiation;
        $this->uv = $uv;
        $this->pm25 = $pm25;
        $this->pm25Avg = $pm25Avg;
        $this->dewPoint = $dewPoint;
        $this->windChill = $windChill;
        $this->aqi = $aqi;
        $this->aqiAvg = $aqiAvg;
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
    public function getRainWeekly(): float
    {
        return $this->rainWeekly;
    }

    /**
     * @return float
     */
    public function getRainMonthly(): float
    {
        return $this->rainMonthly;
    }

    /**
     * @return float
     */
    public function getRainYearly(): float
    {
        return $this->rainYearly;
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
     * @return int
     */
    public function getPm25Avg(): int
    {
        return $this->pm25Avg;
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
