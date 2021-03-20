<?php

namespace App\Core\Transformer;

use App\Entity\Core\ViewModels\WeatherData\WeatherDataDetailView;
use App\Entity\Core\ViewModels\WeatherData\WeatherDataSummaryView;
use App\Entity\WebApp\WeatherData;

class WeatherDataTransformer
{
    /**
     * @var UnitTransformer
     */
    private $unitTransformer;

    /**
     * @var WeatherStationTransformer
     */
    private $weatherStationTransformer;

    /**
     * WeatherDataTransformer constructor.
     * @param UnitTransformer $unitTransformer
     * @param WeatherStationTransformer $weatherStationTransformer
     */
    public function __construct(UnitTransformer $unitTransformer, WeatherStationTransformer $weatherStationTransformer)
    {
        $this->unitTransformer = $unitTransformer;
        $this->weatherStationTransformer = $weatherStationTransformer;
    }

    /**
     * @param WeatherData $currentWeatherData
     * @return WeatherDataSummaryView
     */
    public function transformWeatherDataToSummary(WeatherData $currentWeatherData)
    {
        $unit = $this->unitTransformer->transformUnitToView($currentWeatherData->getUnit());
        $weatherStation = $this->weatherStationTransformer->transformWeatherStationToView($currentWeatherData->getWeatherStation());

        return new WeatherDataSummaryView(
            $currentWeatherData->getId(),
            $weatherStation,
            $unit,
            $currentWeatherData->getTemperature(),
            $currentWeatherData->getRelativePressure(),
            $currentWeatherData->getWindSpeedAvg(),
            $currentWeatherData->getHumidity(),
            $currentWeatherData->getCreatedAt()
        );
    }

    /**
     * @param WeatherData $currentWeatherData
     * @param WeatherData|null $lastHourWeatherData
     * @return WeatherDataDetailView
     */
    public function transformWeatherDataToDetail(WeatherData $currentWeatherData, ?WeatherData $lastHourWeatherData)
    {
        $unit = $this->unitTransformer->transformUnitToView($currentWeatherData->getUnit());
        $weatherStation = $this->weatherStationTransformer->transformWeatherStationToView($currentWeatherData->getWeatherStation());

        $temperatureVariation = $lastHourWeatherData ? $currentWeatherData->getTemperature() - $lastHourWeatherData->getTemperature() : null;
        $relativePressureVariation = $lastHourWeatherData ? $currentWeatherData->getRelativePressure() - $lastHourWeatherData->getRelativePressure() : null;
        $solarRadiationVariation = $lastHourWeatherData ? $currentWeatherData->getSolarRadiation() - $lastHourWeatherData->getSolarRadiation() : null;
        $humidexVariation = $lastHourWeatherData ? $currentWeatherData->getHumidex() - $lastHourWeatherData->getHumidex() : null;

        return new WeatherDataDetailView(
            $currentWeatherData->getId(),
            $weatherStation,
            $unit,
            $currentWeatherData->getTemperature(),
            round($temperatureVariation, 1),
            $currentWeatherData->getHumidity(),
            $currentWeatherData->getRelativePressure(),
            round($relativePressureVariation, 1),
            $currentWeatherData->getAbsolutePressure(),
            $currentWeatherData->getWindDirection(),
            $currentWeatherData->getWindDirectionAvg(),
            $currentWeatherData->getWindSpeed(),
            $currentWeatherData->getWindSpeedAvg(),
            $currentWeatherData->getWindGust(),
            $currentWeatherData->getWindMaxDailyGust(),
            $currentWeatherData->getRainRate(),
            $currentWeatherData->getRainEvent(),
            $currentWeatherData->getRainHourly(),
            $currentWeatherData->getRainDaily(),
            $currentWeatherData->getRainWeekly(),
            $currentWeatherData->getRainMonthly(),
            $currentWeatherData->getRainYearly(),
            $currentWeatherData->getSolarRadiation(),
            round($solarRadiationVariation, 1),
            $currentWeatherData->getUv(),
            $currentWeatherData->getPm25(),
            $currentWeatherData->getPm25Avg(),
            $currentWeatherData->getHumidex(),
            round($humidexVariation, 1),
            $currentWeatherData->getDewPoint(),
            $currentWeatherData->getWindChill(),
            $currentWeatherData->getCloudBase(),
            $currentWeatherData->getBeaufortScale(),
            $currentWeatherData->getAqi(),
            $currentWeatherData->getAqiAvg(),
            $currentWeatherData->getHeatIndex(),
            $currentWeatherData->getCreatedAt()
        );
    }
}
