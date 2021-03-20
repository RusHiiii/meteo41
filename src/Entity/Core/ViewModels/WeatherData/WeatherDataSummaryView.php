<?php


namespace App\Entity\Core\ViewModels\WeatherData;


use App\Entity\Core\ViewModels\Unit\UnitView;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationView;

class WeatherDataSummaryView
{
    private int $id;

    private WeatherStationView $weatherStation;

    private UnitView $unit;

    private float $temperature;

    private float $relativePressure;

    private float $windSpeedAvg;

    private int $humidity;

    private \DateTime $receivedAt;

    /**
     * DataSummary constructor.
     * @param int $id
     * @param WeatherStationView $weatherStation
     * @param UnitView $unit
     * @param float $temperature
     * @param float $relativePressure
     * @param float $windSpeedAvg
     * @param int $humidity
     * @param \DateTime $receivedAt
     */
    public function __construct(int $id, WeatherStationView $weatherStation, UnitView $unit, float $temperature, float $relativePressure, float $windSpeedAvg, int $humidity, \DateTime $receivedAt)
    {
        $this->id = $id;
        $this->weatherStation = $weatherStation;
        $this->unit = $unit;
        $this->temperature = $temperature;
        $this->relativePressure = $relativePressure;
        $this->windSpeedAvg = $windSpeedAvg;
        $this->humidity = $humidity;
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
     * @return WeatherStationView
     */
    public function getWeatherStation(): WeatherStationView
    {
        return $this->weatherStation;
    }

    /**
     * @return UnitView
     */
    public function getUnit(): UnitView
    {
        return $this->unit;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @return float
     */
    public function getRelativePressure(): float
    {
        return $this->relativePressure;
    }

    /**
     * @return float
     */
    public function getWindSpeedAvg(): float
    {
        return $this->windSpeedAvg;
    }

    /**
     * @return int
     */
    public function getHumidity(): int
    {
        return $this->humidity;
    }

    /**
     * @return \DateTime
     */
    public function getReceivedAt(): \DateTime
    {
        return $this->receivedAt;
    }
}