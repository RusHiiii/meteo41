<?php


namespace App\Entity\WebApp;


class WeatherData
{
    private int $id;

    private float $temperature;

    private float $humidity;

    private float $relativePressure;

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

    private int $uv;

    private float $pm25;

    private float $pm25Avg;

    private int $humidex;

    private float $dewPoint;

    private float $windChill;

    private int $cloudBase;

    private \DateTime $lastRain;

    private int $beaufortScale;

    private int $aqi;

    private int $aqiAvg;

    private \DateTime $createdAt;

    private Unit $unit;

    private WeatherStation $weatherStation;

    /**
     * WeatherData constructor.
     * @param float $temperature
     * @param float $humidity
     * @param float $relativePressure
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
     * @param int $uv
     * @param float $pm25
     * @param float $pm25Avg
     * @param int $humidex
     * @param float $dewPoint
     * @param float $windChill
     * @param int $cloudBase
     * @param \DateTime $lastRain
     * @param int $beaufortScale
     * @param int $aqi
     * @param int $aqiAvg
     */
    public function __construct(float $temperature, float $humidity, float $relativePressure, float $absolutePressure, int $windDirection, int $windDirectionAvg, float $windSpeed, float $windSpeedAvg, float $windGust, float $windMaxDailyGust, float $rainRate, float $rainEvent, float $rainHourly, float $rainDaily, float $rainWeekly, float $rainMonthly, float $rainYearly, float $solarRadiation, int $uv, float $pm25, float $pm25Avg, int $humidex, float $dewPoint, float $windChill, int $cloudBase, \DateTime $lastRain, int $beaufortScale, int $aqi, int $aqiAvg)
    {
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->relativePressure = $relativePressure;
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
        $this->uv = $uv;
        $this->pm25 = $pm25;
        $this->pm25Avg = $pm25Avg;
        $this->humidex = $humidex;
        $this->dewPoint = $dewPoint;
        $this->windChill = $windChill;
        $this->cloudBase = $cloudBase;
        $this->lastRain = $lastRain;
        $this->beaufortScale = $beaufortScale;
        $this->aqi = $aqi;
        $this->aqiAvg = $aqiAvg;
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
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @param float $temperature
     */
    public function setTemperature(float $temperature): void
    {
        $this->temperature = $temperature;
    }

    /**
     * @return float
     */
    public function getHumidity(): float
    {
        return $this->humidity;
    }

    /**
     * @param float $humidity
     */
    public function setHumidity(float $humidity): void
    {
        $this->humidity = $humidity;
    }

    /**
     * @return float
     */
    public function getRelativePressure(): float
    {
        return $this->relativePressure;
    }

    /**
     * @param float $relativePressure
     */
    public function setRelativePressure(float $relativePressure): void
    {
        $this->relativePressure = $relativePressure;
    }

    /**
     * @return float
     */
    public function getAbsolutePressure(): float
    {
        return $this->absolutePressure;
    }

    /**
     * @param float $absolutePressure
     */
    public function setAbsolutePressure(float $absolutePressure): void
    {
        $this->absolutePressure = $absolutePressure;
    }

    /**
     * @return int
     */
    public function getWindDirection(): int
    {
        return $this->windDirection;
    }

    /**
     * @param int $windDirection
     */
    public function setWindDirection(int $windDirection): void
    {
        $this->windDirection = $windDirection;
    }

    /**
     * @return int
     */
    public function getWindDirectionAvg(): int
    {
        return $this->windDirectionAvg;
    }

    /**
     * @param int $windDirectionAvg
     */
    public function setWindDirectionAvg(int $windDirectionAvg): void
    {
        $this->windDirectionAvg = $windDirectionAvg;
    }

    /**
     * @return float
     */
    public function getWindSpeed(): float
    {
        return $this->windSpeed;
    }

    /**
     * @param float $windSpeed
     */
    public function setWindSpeed(float $windSpeed): void
    {
        $this->windSpeed = $windSpeed;
    }

    /**
     * @return float
     */
    public function getWindSpeedAvg(): float
    {
        return $this->windSpeedAvg;
    }

    /**
     * @param float $windSpeedAvg
     */
    public function setWindSpeedAvg(float $windSpeedAvg): void
    {
        $this->windSpeedAvg = $windSpeedAvg;
    }

    /**
     * @return float
     */
    public function getWindGust(): float
    {
        return $this->windGust;
    }

    /**
     * @param float $windGust
     */
    public function setWindGust(float $windGust): void
    {
        $this->windGust = $windGust;
    }

    /**
     * @return float
     */
    public function getWindMaxDailyGust(): float
    {
        return $this->windMaxDailyGust;
    }

    /**
     * @param float $windMaxDailyGust
     */
    public function setWindMaxDailyGust(float $windMaxDailyGust): void
    {
        $this->windMaxDailyGust = $windMaxDailyGust;
    }

    /**
     * @return float
     */
    public function getRainRate(): float
    {
        return $this->rainRate;
    }

    /**
     * @param float $rainRate
     */
    public function setRainRate(float $rainRate): void
    {
        $this->rainRate = $rainRate;
    }

    /**
     * @return float
     */
    public function getRainEvent(): float
    {
        return $this->rainEvent;
    }

    /**
     * @param float $rainEvent
     */
    public function setRainEvent(float $rainEvent): void
    {
        $this->rainEvent = $rainEvent;
    }

    /**
     * @return float
     */
    public function getRainHourly(): float
    {
        return $this->rainHourly;
    }

    /**
     * @param float $rainHourly
     */
    public function setRainHourly(float $rainHourly): void
    {
        $this->rainHourly = $rainHourly;
    }

    /**
     * @return float
     */
    public function getRainDaily(): float
    {
        return $this->rainDaily;
    }

    /**
     * @param float $rainDaily
     */
    public function setRainDaily(float $rainDaily): void
    {
        $this->rainDaily = $rainDaily;
    }

    /**
     * @return float
     */
    public function getRainWeekly(): float
    {
        return $this->rainWeekly;
    }

    /**
     * @param float $rainWeekly
     */
    public function setRainWeekly(float $rainWeekly): void
    {
        $this->rainWeekly = $rainWeekly;
    }

    /**
     * @return float
     */
    public function getRainMonthly(): float
    {
        return $this->rainMonthly;
    }

    /**
     * @param float $rainMonthly
     */
    public function setRainMonthly(float $rainMonthly): void
    {
        $this->rainMonthly = $rainMonthly;
    }

    /**
     * @return float
     */
    public function getRainYearly(): float
    {
        return $this->rainYearly;
    }

    /**
     * @param float $rainYearly
     */
    public function setRainYearly(float $rainYearly): void
    {
        $this->rainYearly = $rainYearly;
    }

    /**
     * @return float
     */
    public function getSolarRadiation(): float
    {
        return $this->solarRadiation;
    }

    /**
     * @param float $solarRadiation
     */
    public function setSolarRadiation(float $solarRadiation): void
    {
        $this->solarRadiation = $solarRadiation;
    }

    /**
     * @return int
     */
    public function getUv(): int
    {
        return $this->uv;
    }

    /**
     * @param int $uv
     */
    public function setUv(int $uv): void
    {
        $this->uv = $uv;
    }

    /**
     * @return float
     */
    public function getPm25(): float
    {
        return $this->pm25;
    }

    /**
     * @param float $pm25
     */
    public function setPm25(float $pm25): void
    {
        $this->pm25 = $pm25;
    }

    /**
     * @return float
     */
    public function getPm25Avg(): float
    {
        return $this->pm25Avg;
    }

    /**
     * @param float $pm25Avg
     */
    public function setPm25Avg(float $pm25Avg): void
    {
        $this->pm25Avg = $pm25Avg;
    }

    /**
     * @return int
     */
    public function getHumidex(): int
    {
        return $this->humidex;
    }

    /**
     * @param int $humidex
     */
    public function setHumidex(int $humidex): void
    {
        $this->humidex = $humidex;
    }

    /**
     * @return float
     */
    public function getDewPoint(): float
    {
        return $this->dewPoint;
    }

    /**
     * @param float $dewPoint
     */
    public function setDewPoint(float $dewPoint): void
    {
        $this->dewPoint = $dewPoint;
    }

    /**
     * @return float
     */
    public function getWindChill(): float
    {
        return $this->windChill;
    }

    /**
     * @param float $windChill
     */
    public function setWindChill(float $windChill): void
    {
        $this->windChill = $windChill;
    }

    /**
     * @return int
     */
    public function getCloudBase(): int
    {
        return $this->cloudBase;
    }

    /**
     * @param int $cloudBase
     */
    public function setCloudBase(int $cloudBase): void
    {
        $this->cloudBase = $cloudBase;
    }

    /**
     * @return \DateTime
     */
    public function getLastRain(): \DateTime
    {
        return $this->lastRain;
    }

    /**
     * @param \DateTime $lastRain
     */
    public function setLastRain(\DateTime $lastRain): void
    {
        $this->lastRain = $lastRain;
    }

    /**
     * @return int
     */
    public function getBeaufortScale(): int
    {
        return $this->beaufortScale;
    }

    /**
     * @param int $beaufortScale
     */
    public function setBeaufortScale(int $beaufortScale): void
    {
        $this->beaufortScale = $beaufortScale;
    }

    /**
     * @return int
     */
    public function getAqi(): int
    {
        return $this->aqi;
    }

    /**
     * @param int $aqi
     */
    public function setAqi(int $aqi): void
    {
        $this->aqi = $aqi;
    }

    /**
     * @return int
     */
    public function getAqiAvg(): int
    {
        return $this->aqiAvg;
    }

    /**
     * @param int $aqiAvg
     */
    public function setAqiAvg(int $aqiAvg): void
    {
        $this->aqiAvg = $aqiAvg;
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
     * @return Unit
     */
    public function getUnit(): Unit
    {
        return $this->unit;
    }

    /**
     * @param Unit $unit
     */
    public function setUnit(Unit $unit): void
    {
        $this->unit = $unit;
    }

    /**
     * @return WeatherStation
     */
    public function getWeatherStation(): WeatherStation
    {
        return $this->weatherStation;
    }

    /**
     * @param WeatherStation $weatherStation
     */
    public function setWeatherStation(WeatherStation $weatherStation): void
    {
        $this->weatherStation = $weatherStation;
    }
}