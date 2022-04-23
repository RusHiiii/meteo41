<?php

namespace App\Entity\Core\ViewModels\WeatherData;

use App\Entity\Core\ViewModels\Unit\UnitView;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationView;

class WeatherDataDetailView
{
    private int $id;

    private WeatherStationView $weatherStation;

    private UnitView $unit;

    private float $temperature;

    private ?float $temperatureVariation;

    private int $humidity;

    private float $relativePressure;

    private ?float $relativePressureVariation;

    private float $absolutePressure;

    private int $windDirection;

    private int $windDirectionAvg;

    private float $windSpeed;

    private float $windSpeedAvg;

    private float $windGust;

    private float $windMaxDailyGust;

    private float $rainRate;

    private float $rainEvent;

    private float $rainHourly;

    private float $rainDaily;

    private float $rainWeekly;

    private float $rainMonthly;

    private float $rainYearly;

    private float $solarRadiation;

    private ?float $solarRadiationVariation;

    private int $uv;

    private int $pm25;

    private int $pm25Avg;

    private float $humidex;

    private ?float $humidexVariation;

    private float $dewPoint;

    private float $windChill;

    private int $cloudBase;

    private int $beaufortScale;

    private int $aqi;

    private int $aqiAvg;

    private float $heatIndex;

    private ?int $leafWetness;

    private ?float $soilTemperature;

    private ?float $soilTemperatureVariation;

    private \DateTime $receivedAt;

    /**
     * WeatherDataDetailView constructor.
     * @param int $id
     * @param WeatherStationView $weatherStation
     * @param UnitView $unit
     * @param float $temperature
     * @param float|null $temperatureVariation
     * @param int $humidity
     * @param float $relativePressure
     * @param float|null $relativePressureVariation
     * @param float $absolutePressure
     * @param int $windDirection
     * @param int $windDirectionAvg
     * @param float $windSpeed
     * @param float $windSpeedAvg
     * @param float $windGust
     * @param float $windMaxDailyGust
     * @param float $rainRate
     * @param float $rainEvent
     * @param float $rainHourly
     * @param float $rainDaily
     * @param float $rainWeekly
     * @param float $rainMonthly
     * @param float $rainYearly
     * @param float $solarRadiation
     * @param float|null $solarRadiationVariation
     * @param int $uv
     * @param int $pm25
     * @param int $pm25Avg
     * @param float $humidex
     * @param float|null $humidexVariation
     * @param float $dewPoint
     * @param float $windChill
     * @param int $cloudBase
     * @param int $beaufortScale
     * @param int $aqi
     * @param int $aqiAvg
     * @param float $heatIndex
     * @param float|null $soilTemperature
     * @param float|null $soilTemperatureVariation
     * @param int|null $leafWetness
     * @param \DateTime $receivedAt
     */
    public function __construct(int $id, WeatherStationView $weatherStation, UnitView $unit, float $temperature, ?float $temperatureVariation, int $humidity, float $relativePressure, ?float $relativePressureVariation, float $absolutePressure, int $windDirection, int $windDirectionAvg, float $windSpeed, float $windSpeedAvg, float $windGust, float $windMaxDailyGust, float $rainRate, float $rainEvent, float $rainHourly, float $rainDaily, float $rainWeekly, float $rainMonthly, float $rainYearly, float $solarRadiation, ?float $solarRadiationVariation, int $uv, int $pm25, int $pm25Avg, float $humidex, ?float $humidexVariation, float $dewPoint, float $windChill, int $cloudBase, int $beaufortScale, int $aqi, int $aqiAvg, float $heatIndex, ?float $soilTemperature, ?int $leafWetness, ?float $soilTemperatureVariation, \DateTime $receivedAt)
    {
        $this->id = $id;
        $this->weatherStation = $weatherStation;
        $this->unit = $unit;
        $this->temperature = $temperature;
        $this->temperatureVariation = $temperatureVariation;
        $this->humidity = $humidity;
        $this->relativePressure = $relativePressure;
        $this->relativePressureVariation = $relativePressureVariation;
        $this->absolutePressure = $absolutePressure;
        $this->windDirection = $windDirection;
        $this->windDirectionAvg = $windDirectionAvg;
        $this->windSpeed = $windSpeed;
        $this->windSpeedAvg = $windSpeedAvg;
        $this->windGust = $windGust;
        $this->windMaxDailyGust = $windMaxDailyGust;
        $this->rainRate = $rainRate;
        $this->rainEvent = $rainEvent;
        $this->rainHourly = $rainHourly;
        $this->rainDaily = $rainDaily;
        $this->rainWeekly = $rainWeekly;
        $this->rainMonthly = $rainMonthly;
        $this->rainYearly = $rainYearly;
        $this->solarRadiation = $solarRadiation;
        $this->solarRadiationVariation = $solarRadiationVariation;
        $this->uv = $uv;
        $this->pm25 = $pm25;
        $this->pm25Avg = $pm25Avg;
        $this->humidex = $humidex;
        $this->humidexVariation = $humidexVariation;
        $this->dewPoint = $dewPoint;
        $this->windChill = $windChill;
        $this->cloudBase = $cloudBase;
        $this->beaufortScale = $beaufortScale;
        $this->aqi = $aqi;
        $this->aqiAvg = $aqiAvg;
        $this->heatIndex = $heatIndex;
        $this->receivedAt = $receivedAt;
        $this->soilTemperature = $soilTemperature;
        $this->leafWetness = $leafWetness;
        $this->soilTemperatureVariation = $soilTemperatureVariation;
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
     * @return int|null
     */
    public function getLeafWetness(): ?int
    {
        return $this->leafWetness;
    }

    /**
     * @return float|null
     */
    public function getSoilTemperature(): ?float
    {
        return $this->soilTemperature;
    }

    /**
     * @return float|null
     */
    public function getSoilTemperatureVariation(): ?float
    {
        return $this->soilTemperatureVariation;
    }

    /**
     * @return float|null
     */
    public function getTemperatureVariation(): ?float
    {
        return $this->temperatureVariation;
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
     * @return float|null
     */
    public function getRelativePressureVariation(): ?float
    {
        return $this->relativePressureVariation;
    }

    /**
     * @return float
     */
    public function getAbsolutePressure(): float
    {
        return $this->absolutePressure;
    }

    /**
     * @return int
     */
    public function getWindDirection(): int
    {
        return $this->windDirection;
    }

    /**
     * @return int
     */
    public function getWindDirectionAvg(): int
    {
        return $this->windDirectionAvg;
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
    public function getWindSpeedAvg(): float
    {
        return $this->windSpeedAvg;
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
    public function getWindMaxDailyGust(): float
    {
        return $this->windMaxDailyGust;
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
    public function getRainEvent(): float
    {
        return $this->rainEvent;
    }

    /**
     * @return float
     */
    public function getRainHourly(): float
    {
        return $this->rainHourly;
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
     * @return float|null
     */
    public function getSolarRadiationVariation(): ?float
    {
        return $this->solarRadiationVariation;
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
    public function getHumidex(): float
    {
        return $this->humidex;
    }

    /**
     * @return float|null
     */
    public function getHumidexVariation(): ?float
    {
        return $this->humidexVariation;
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
    public function getCloudBase(): int
    {
        return $this->cloudBase;
    }

    /**
     * @return int
     */
    public function getBeaufortScale(): int
    {
        return $this->beaufortScale;
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
     * @return float
     */
    public function getHeatIndex(): float
    {
        return $this->heatIndex;
    }

    /**
     * @return \DateTime
     */
    public function getReceivedAt(): \DateTime
    {
        return $this->receivedAt;
    }
}
