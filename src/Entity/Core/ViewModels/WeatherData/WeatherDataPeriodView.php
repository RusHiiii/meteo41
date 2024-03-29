<?php

namespace App\Entity\Core\ViewModels\WeatherData;

use App\Entity\Core\ViewModels\Unit\UnitView;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationView;

class WeatherDataPeriodView
{
    private WeatherStationView $weatherStation;

    private UnitView $unit;

    private float $maxTemperature;

    private \DateTime $maxTemperatureReceivedAt;

    private float $minTemperature;

    private \DateTime $minTemperatureReceivedAt;

    private ?float $maxSoilTemperature;

    private ?\DateTime $maxSoilTemperatureReceivedAt;

    private ?float $minSoilTemperature;

    private ?\DateTime $minSoilTemperatureReceivedAt;

    private float $maxHumidex;

    private \DateTime $maxHumidexReceivedAt;

    private ?int $maxLeafWetness;

    private ?\DateTime $maxLeafWetnessReceivedAt;

    private float $minHumidex;

    private \DateTime $minHumidexReceivedAt;

    private float $maxDewPoint;

    private \DateTime $maxDewPointReceivedAt;

    private float $minDewPoint;

    private \DateTime $minDewPointReceivedAt;

    private float $maxWindChill;

    private \DateTime $maxWindChillReceivedAt;

    private float $minWindChill;

    private \DateTime $minWindChillReceivedAt;

    private int $maxHumidity;

    private \DateTime $maxHumidityReceivedAt;

    private int $minHumidity;

    private \DateTime $minHumidityReceivedAt;

    private float $maxRelativePressure;

    private \DateTime $maxRelativePressureReceivedAt;

    private float $minRelativePressure;

    private \DateTime $minRelativePressureReceivedAt;

    private float $maxRainRate;

    private \DateTime $maxRainRateReceivedAt;

    private float $maxRainEvent;

    private \DateTime $maxRainEventReceivedAt;

    private ?float $rainPeriod;

    private float $maxWindGust;

    private \DateTime $maxWindGustReceivedAt;

    private int $maxBeaufortScale;

    private \DateTime $maxBeaufortScaleReceivedAt;

    private ?float $avgPm25;

    private ?float $avgAqi;

    private ?float $maxPm25;

    private ?\DateTime $maxPm25ReceivedAt;

    private ?int $maxAqi;

    private ?\DateTime $maxAqiReceivedAt;

    private float $maxSolarRadiation;

    private \DateTime $maxSolarRadiationReceivedAt;

    private int $maxUv;

    private \DateTime $maxUvReceivedAt;

    private ?float $minPm25;

    private ?\DateTime $minPm25ReceivedAt;

    private ?int $minAqi;

    private ?\DateTime $minAqiReceivedAt;

    private float $maxHeatIndex;

    private \DateTime $maxHeatIndexReceivedAt;

    private float $minHeatIndex;

    private \DateTime $minHeatIndexReceivedAt;

    private ?int $minLightningDistance;

    private ?\DateTime $minLightningDistanceReceivedAt;

    private ?int $maxLightningDistance;

    private ?\DateTime $maxLightningDistanceReceivedAt;

    private int $lightningNumber;

    /**
     * @param WeatherStationView $weatherStation
     * @param UnitView $unit
     * @param float $maxTemperature
     * @param \DateTime $maxTemperatureReceivedAt
     * @param float $minTemperature
     * @param \DateTime $minTemperatureReceivedAt
     * @param float $maxHumidex
     * @param \DateTime $maxHumidexReceivedAt
     * @param float $minHumidex
     * @param \DateTime $minHumidexReceivedAt
     * @param float $maxDewPoint
     * @param \DateTime $maxDewPointReceivedAt
     * @param float $minDewPoint
     * @param \DateTime $minDewPointReceivedAt
     * @param float $maxWindChill
     * @param \DateTime $maxWindChillReceivedAt
     * @param float $minWindChill
     * @param \DateTime $minWindChillReceivedAt
     * @param int $maxHumidity
     * @param \DateTime $maxHumidityReceivedAt
     * @param int $minHumidity
     * @param \DateTime $minHumidityReceivedAt
     * @param float $maxRelativePressure
     * @param \DateTime $maxRelativePressureReceivedAt
     * @param float $minRelativePressure
     * @param \DateTime $minRelativePressureReceivedAt
     * @param float $maxRainRate
     * @param \DateTime $maxRainRateReceivedAt
     * @param float $maxRainEvent
     * @param \DateTime $maxRainEventReceivedAt
     * @param float|null $rainPeriod
     * @param float $maxWindGust
     * @param \DateTime $maxWindGustReceivedAt
     * @param int $maxBeaufortScale
     * @param \DateTime $maxBeaufortScaleReceivedAt
     * @param float|null $avgPm25
     * @param float|null $avgAqi
     * @param float|null $maxPm25
     * @param \DateTime|null $maxPm25ReceivedAt
     * @param int|null $maxAqi
     * @param \DateTime|null $maxAqiReceivedAt
     * @param float $maxSolarRadiation
     * @param \DateTime $maxSolarRadiationReceivedAt
     * @param int $maxUv
     * @param \DateTime $maxUvReceivedAt
     * @param float|null $minPm25
     * @param \DateTime|null $minPm25ReceivedAt
     * @param int|null $minAqi
     * @param \DateTime|null $minAqiReceivedAt
     * @param float $minHeatIndex
     * @param \DateTime $minHeatIndexReceivedAt
     * @param float $maxHeatIndex
     * @param \DateTime $maxHeatIndexReceivedAt
     * @param float|null $minSoilTemperature
     * @param \DateTime|null $minSoilTemperatureReceivedAt
     * @param float|null $maxSoilTemperature
     * @param \DateTime|null $maxSoilTemperatureReceivedAt
     * @param int|null $maxLeafWetness
     * @param \DateTime|null $maxLeafWetnessReceivedAt
     * @param int|null $minLightningDistance
     * @param \DateTime|null $minLightningDistanceReceivedAt
     * @param int|null $maxLightningDistance
     * @param \DateTime|null $maxLightningDistanceReceivedAt
     * @param int $lightningNumber
     */
    public function __construct(WeatherStationView $weatherStation, UnitView $unit, float $maxTemperature, \DateTime $maxTemperatureReceivedAt, float $minTemperature, \DateTime $minTemperatureReceivedAt, float $maxHumidex, \DateTime $maxHumidexReceivedAt, float $minHumidex, \DateTime $minHumidexReceivedAt, float $maxDewPoint, \DateTime $maxDewPointReceivedAt, float $minDewPoint, \DateTime $minDewPointReceivedAt, float $maxWindChill, \DateTime $maxWindChillReceivedAt, float $minWindChill, \DateTime $minWindChillReceivedAt, int $maxHumidity, \DateTime $maxHumidityReceivedAt, int $minHumidity, \DateTime $minHumidityReceivedAt, float $maxRelativePressure, \DateTime $maxRelativePressureReceivedAt, float $minRelativePressure, \DateTime $minRelativePressureReceivedAt, float $maxRainRate, \DateTime $maxRainRateReceivedAt, float $maxRainEvent, \DateTime $maxRainEventReceivedAt, ?float $rainPeriod, float $maxWindGust, \DateTime $maxWindGustReceivedAt, int $maxBeaufortScale, \DateTime $maxBeaufortScaleReceivedAt, ?float $avgPm25, ?float $avgAqi, ?float $maxPm25, ?\DateTime $maxPm25ReceivedAt, ?int $maxAqi, ?\DateTime $maxAqiReceivedAt, float $maxSolarRadiation, \DateTime $maxSolarRadiationReceivedAt, int $maxUv, \DateTime $maxUvReceivedAt, ?float $minPm25, ?\DateTime $minPm25ReceivedAt, ?int $minAqi, ?\DateTime $minAqiReceivedAt, float $minHeatIndex, \DateTime $minHeatIndexReceivedAt, float $maxHeatIndex, \DateTime $maxHeatIndexReceivedAt, ?float $minSoilTemperature, ?\DateTime $minSoilTemperatureReceivedAt, ?float $maxSoilTemperature, ?\DateTime $maxSoilTemperatureReceivedAt, ?int $maxLeafWetness, ?\DateTime $maxLeafWetnessReceivedAt, ?int $minLightningDistance, ?\DateTime $minLightningDistanceReceivedAt, ?int $maxLightningDistance, ?\DateTime $maxLightningDistanceReceivedAt, int $lightningNumber)
    {
        $this->weatherStation = $weatherStation;
        $this->unit = $unit;
        $this->maxTemperature = $maxTemperature;
        $this->maxTemperatureReceivedAt = $maxTemperatureReceivedAt;
        $this->minTemperature = $minTemperature;
        $this->minTemperatureReceivedAt = $minTemperatureReceivedAt;
        $this->maxHumidex = $maxHumidex;
        $this->maxHumidexReceivedAt = $maxHumidexReceivedAt;
        $this->minHumidex = $minHumidex;
        $this->minHumidexReceivedAt = $minHumidexReceivedAt;
        $this->maxDewPoint = $maxDewPoint;
        $this->maxDewPointReceivedAt = $maxDewPointReceivedAt;
        $this->minDewPoint = $minDewPoint;
        $this->minDewPointReceivedAt = $minDewPointReceivedAt;
        $this->maxWindChill = $maxWindChill;
        $this->maxWindChillReceivedAt = $maxWindChillReceivedAt;
        $this->minWindChill = $minWindChill;
        $this->minWindChillReceivedAt = $minWindChillReceivedAt;
        $this->maxHumidity = $maxHumidity;
        $this->maxHumidityReceivedAt = $maxHumidityReceivedAt;
        $this->minHumidity = $minHumidity;
        $this->minHumidityReceivedAt = $minHumidityReceivedAt;
        $this->maxRelativePressure = $maxRelativePressure;
        $this->maxRelativePressureReceivedAt = $maxRelativePressureReceivedAt;
        $this->minRelativePressure = $minRelativePressure;
        $this->minRelativePressureReceivedAt = $minRelativePressureReceivedAt;
        $this->maxRainRate = $maxRainRate;
        $this->maxRainRateReceivedAt = $maxRainRateReceivedAt;
        $this->maxRainEvent = $maxRainEvent;
        $this->maxRainEventReceivedAt = $maxRainEventReceivedAt;
        $this->rainPeriod = $rainPeriod;
        $this->maxWindGust = $maxWindGust;
        $this->maxWindGustReceivedAt = $maxWindGustReceivedAt;
        $this->maxBeaufortScale = $maxBeaufortScale;
        $this->maxBeaufortScaleReceivedAt = $maxBeaufortScaleReceivedAt;
        $this->avgPm25 = $avgPm25;
        $this->avgAqi = $avgAqi;
        $this->maxPm25 = $maxPm25;
        $this->maxPm25ReceivedAt = $maxPm25ReceivedAt;
        $this->maxAqi = $maxAqi;
        $this->maxAqiReceivedAt = $maxAqiReceivedAt;
        $this->maxSolarRadiation = $maxSolarRadiation;
        $this->maxSolarRadiationReceivedAt = $maxSolarRadiationReceivedAt;
        $this->maxUv = $maxUv;
        $this->maxUvReceivedAt = $maxUvReceivedAt;
        $this->minPm25 = $minPm25;
        $this->minPm25ReceivedAt = $minPm25ReceivedAt;
        $this->minAqi = $minAqi;
        $this->minAqiReceivedAt = $minAqiReceivedAt;
        $this->minHeatIndex = $minHeatIndex;
        $this->minHeatIndexReceivedAt = $minHeatIndexReceivedAt;
        $this->maxHeatIndex = $maxHeatIndex;
        $this->maxHeatIndexReceivedAt = $maxHeatIndexReceivedAt;
        $this->maxLeafWetness = $maxLeafWetness;
        $this->maxLeafWetnessReceivedAt = $maxLeafWetnessReceivedAt;
        $this->minSoilTemperature = $minSoilTemperature;
        $this->minSoilTemperatureReceivedAt = $minSoilTemperatureReceivedAt;
        $this->maxSoilTemperature = $maxSoilTemperature;
        $this->maxSoilTemperatureReceivedAt = $maxSoilTemperatureReceivedAt;
        $this->minLightningDistance = $minLightningDistance;
        $this->minLightningDistanceReceivedAt = $minLightningDistanceReceivedAt;
        $this->maxLightningDistance = $maxLightningDistance;
        $this->maxLightningDistanceReceivedAt = $maxLightningDistanceReceivedAt;
        $this->lightningNumber = $lightningNumber;
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
    public function getMaxTemperature(): float
    {
        return $this->maxTemperature;
    }

    /**
     * @return \DateTime
     */
    public function getMaxTemperatureReceivedAt(): \DateTime
    {
        return $this->maxTemperatureReceivedAt;
    }

    /**
     * @return float
     */
    public function getMinTemperature(): float
    {
        return $this->minTemperature;
    }

    /**
     * @return \DateTime
     */
    public function getMinTemperatureReceivedAt(): \DateTime
    {
        return $this->minTemperatureReceivedAt;
    }

    /**
     * @return float
     */
    public function getMaxHumidex(): float
    {
        return $this->maxHumidex;
    }

    /**
     * @return \DateTime
     */
    public function getMaxHumidexReceivedAt(): \DateTime
    {
        return $this->maxHumidexReceivedAt;
    }

    /**
     * @return float
     */
    public function getMinHumidex(): float
    {
        return $this->minHumidex;
    }

    /**
     * @return \DateTime
     */
    public function getMinHumidexReceivedAt(): \DateTime
    {
        return $this->minHumidexReceivedAt;
    }

    /**
     * @return float
     */
    public function getMaxDewPoint(): float
    {
        return $this->maxDewPoint;
    }

    /**
     * @return \DateTime
     */
    public function getMaxDewPointReceivedAt(): \DateTime
    {
        return $this->maxDewPointReceivedAt;
    }

    /**
     * @return float
     */
    public function getMinDewPoint(): float
    {
        return $this->minDewPoint;
    }

    /**
     * @return \DateTime
     */
    public function getMinDewPointReceivedAt(): \DateTime
    {
        return $this->minDewPointReceivedAt;
    }

    /**
     * @return float
     */
    public function getMaxWindChill(): float
    {
        return $this->maxWindChill;
    }

    /**
     * @return \DateTime
     */
    public function getMaxWindChillReceivedAt(): \DateTime
    {
        return $this->maxWindChillReceivedAt;
    }

    /**
     * @return float
     */
    public function getMinWindChill(): float
    {
        return $this->minWindChill;
    }

    /**
     * @return \DateTime
     */
    public function getMinWindChillReceivedAt(): \DateTime
    {
        return $this->minWindChillReceivedAt;
    }

    /**
     * @return int
     */
    public function getMaxHumidity(): int
    {
        return $this->maxHumidity;
    }

    /**
     * @return \DateTime
     */
    public function getMaxHumidityReceivedAt(): \DateTime
    {
        return $this->maxHumidityReceivedAt;
    }

    /**
     * @return int
     */
    public function getMinHumidity(): int
    {
        return $this->minHumidity;
    }

    /**
     * @return \DateTime
     */
    public function getMinHumidityReceivedAt(): \DateTime
    {
        return $this->minHumidityReceivedAt;
    }

    /**
     * @return float
     */
    public function getMaxRelativePressure(): float
    {
        return $this->maxRelativePressure;
    }

    /**
     * @return \DateTime
     */
    public function getMaxRelativePressureReceivedAt(): \DateTime
    {
        return $this->maxRelativePressureReceivedAt;
    }

    /**
     * @return float
     */
    public function getMinRelativePressure(): float
    {
        return $this->minRelativePressure;
    }

    /**
     * @return \DateTime
     */
    public function getMinRelativePressureReceivedAt(): \DateTime
    {
        return $this->minRelativePressureReceivedAt;
    }

    /**
     * @return float
     */
    public function getMaxRainRate(): float
    {
        return $this->maxRainRate;
    }

    /**
     * @return \DateTime
     */
    public function getMaxRainRateReceivedAt(): \DateTime
    {
        return $this->maxRainRateReceivedAt;
    }

    /**
     * @return float
     */
    public function getMaxRainEvent(): float
    {
        return $this->maxRainEvent;
    }

    /**
     * @return \DateTime
     */
    public function getMaxRainEventReceivedAt(): \DateTime
    {
        return $this->maxRainEventReceivedAt;
    }

    /**
     * @return float|null
     */
    public function getRainPeriod(): ?float
    {
        return $this->rainPeriod;
    }

    /**
     * @return float
     */
    public function getMaxWindGust(): float
    {
        return $this->maxWindGust;
    }

    /**
     * @return \DateTime
     */
    public function getMaxWindGustReceivedAt(): \DateTime
    {
        return $this->maxWindGustReceivedAt;
    }

    /**
     * @return int
     */
    public function getMaxBeaufortScale(): int
    {
        return $this->maxBeaufortScale;
    }

    /**
     * @return \DateTime
     */
    public function getMaxBeaufortScaleReceivedAt(): \DateTime
    {
        return $this->maxBeaufortScaleReceivedAt;
    }

    /**
     * @return float|null
     */
    public function getAvgPm25(): ?float
    {
        return $this->avgPm25;
    }

    /**
     * @return float|null
     */
    public function getAvgAqi(): ?float
    {
        return $this->avgAqi;
    }

    /**
     * @return float|null
     */
    public function getMaxPm25(): ?float
    {
        return $this->maxPm25;
    }

    /**
     * @return \DateTime|null
     */
    public function getMaxPm25ReceivedAt(): ?\DateTime
    {
        return $this->maxPm25ReceivedAt;
    }

    /**
     * @return int|null
     */
    public function getMaxAqi(): ?int
    {
        return $this->maxAqi;
    }

    /**
     * @return \DateTime|null
     */
    public function getMaxAqiReceivedAt(): ?\DateTime
    {
        return $this->maxAqiReceivedAt;
    }

    /**
     * @return float
     */
    public function getMaxSolarRadiation(): float
    {
        return $this->maxSolarRadiation;
    }

    /**
     * @return \DateTime
     */
    public function getMaxSolarRadiationReceivedAt(): \DateTime
    {
        return $this->maxSolarRadiationReceivedAt;
    }

    /**
     * @return int
     */
    public function getMaxUv(): int
    {
        return $this->maxUv;
    }

    /**
     * @return \DateTime
     */
    public function getMaxUvReceivedAt(): \DateTime
    {
        return $this->maxUvReceivedAt;
    }

    /**
     * @return float|null
     */
    public function getMinPm25(): ?float
    {
        return $this->minPm25;
    }

    /**
     * @return \DateTime|null
     */
    public function getMinPm25ReceivedAt(): ?\DateTime
    {
        return $this->minPm25ReceivedAt;
    }

    /**
     * @return int|null
     */
    public function getMinAqi(): ?int
    {
        return $this->minAqi;
    }

    /**
     * @return \DateTime|null
     */
    public function getMinAqiReceivedAt(): ?\DateTime
    {
        return $this->minAqiReceivedAt;
    }

    /**
     * @return float
     */
    public function getMaxHeatIndex(): float
    {
        return $this->maxHeatIndex;
    }

    /**
     * @return \DateTime
     */
    public function getMaxHeatIndexReceivedAt(): \DateTime
    {
        return $this->maxHeatIndexReceivedAt;
    }

    /**
     * @return float
     */
    public function getMinHeatIndex(): float
    {
        return $this->minHeatIndex;
    }

    /**
     * @return \DateTime
     */
    public function getMinHeatIndexReceivedAt(): \DateTime
    {
        return $this->minHeatIndexReceivedAt;
    }

    /**
     * @return float|null
     */
    public function getMaxSoilTemperature(): ?float
    {
        return $this->maxSoilTemperature;
    }

    /**
     * @return \DateTime|null
     */
    public function getMaxSoilTemperatureReceivedAt(): ?\DateTime
    {
        return $this->maxSoilTemperatureReceivedAt;
    }

    /**
     * @return float|null
     */
    public function getMinSoilTemperature(): ?float
    {
        return $this->minSoilTemperature;
    }

    /**
     * @return \DateTime|null
     */
    public function getMinSoilTemperatureReceivedAt(): ?\DateTime
    {
        return $this->minSoilTemperatureReceivedAt;
    }

    /**
     * @return int|null
     */
    public function getMaxLeafWetness(): ?int
    {
        return $this->maxLeafWetness;
    }

    /**
     * @return \DateTime|null
     */
    public function getMaxLeafWetnessReceivedAt(): ?\DateTime
    {
        return $this->maxLeafWetnessReceivedAt;
    }

    /**
     * @return int|null
     */
    public function getMinLightningDistance(): ?int
    {
        return $this->minLightningDistance;
    }

    /**
     * @return \DateTime|null
     */
    public function getMinLightningDistanceReceivedAt(): ?\DateTime
    {
        return $this->minLightningDistanceReceivedAt;
    }

    /**
     * @return int|null
     */
    public function getMaxLightningDistance(): ?int
    {
        return $this->maxLightningDistance;
    }

    /**
     * @return \DateTime|null
     */
    public function getMaxLightningDistanceReceivedAt(): ?\DateTime
    {
        return $this->maxLightningDistanceReceivedAt;
    }

    /**
     * @return int
     */
    public function getLightningNumber(): int
    {
        return $this->lightningNumber;
    }
}
