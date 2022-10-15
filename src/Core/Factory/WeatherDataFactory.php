<?php

namespace App\Core\Factory;

use App\Core\Tactician\Command\WeatherData\RegisterWeatherDataCommand;
use App\Entity\WebApp\Unit;
use App\Entity\WebApp\WeatherData;
use App\Entity\WebApp\WeatherStation;

class WeatherDataFactory
{
    /**
     * @param RegisterWeatherDataCommand $command
     * @param float $heatIndex
     * @param float $temperature
     * @param float $relativePressure
     * @param float $absolutePressure
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
     * @param float $humidex
     * @param float $dewPoint
     * @param float $windChill
     * @param int $cloudBase
     * @param int $beaufortScale
     * @param int $aqi
     * @param int $aqiAvg
     * @param Unit $preferedUnit
     * @param WeatherStation $weatherStation
     * @return WeatherData
     */
    public function createWeatherDataFromCommand(RegisterWeatherDataCommand $command, float $heatIndex, float $temperature, float $relativePressure, float $absolutePressure, float $windSpeed, float $windSpeedAvg, float $windGust, float $windMaxDailyGust, float $rainRate, float $rainEvent, float $rainHourly, float $rainDaily, float $rainWeekly, float $rainMonthly, float $rainYearly, float $humidex, float $dewPoint, float $windChill, int $cloudBase, int $beaufortScale, ?int $aqi, ?int $aqiAvg, ?int $leafWetness, ?float $soilTemperature, Unit $preferedUnit, WeatherStation $weatherStation)
    {
        $weatherData = new WeatherData(
            $heatIndex,
            $temperature,
            $command->getHumidity(),
            $relativePressure,
            $absolutePressure,
            $command->getWindDirection(),
            $command->getAverageWindDirection10m(),
            $windSpeed,
            $windSpeedAvg,
            $windGust,
            $windMaxDailyGust,
            $rainRate,
            $rainEvent,
            $rainHourly,
            $rainDaily,
            $rainWeekly,
            $rainMonthly,
            $rainYearly,
            $command->getSolarRadiation(),
            $command->getUv(),
            $command->getPm25(),
            $command->getAveragePm25Days(),
            $humidex,
            $dewPoint,
            $windChill,
            $cloudBase,
            $beaufortScale,
            $aqi,
            $aqiAvg,
            $soilTemperature,
            $leafWetness,
            $command->getDate()
        );

        $weatherData->setUnit($preferedUnit);
        $weatherData->setWeatherStation($weatherStation);

        return $weatherData;
    }
}
