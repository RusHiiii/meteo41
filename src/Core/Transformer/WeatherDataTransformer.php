<?php

namespace App\Core\Transformer;

use App\Entity\Core\ViewModels\WeatherData\WeatherDataDetailView;
use App\Entity\Core\ViewModels\WeatherData\WeatherDataGraphSearchView;
use App\Entity\Core\ViewModels\WeatherData\WeatherDataGraphView;
use App\Entity\Core\ViewModels\WeatherData\WeatherDataPeriodView;
use App\Entity\Core\ViewModels\WeatherData\WeatherDataSummaryView;
use App\Entity\WebApp\WeatherData;
use App\Entity\WebApp\WeatherStation;

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
     * @param array $weatherData
     * @param WeatherStation $weatherStation
     * @return WeatherDataPeriodView
     */
    public function transformWeatherDataToPeriod(array $weatherData, WeatherStation $weatherStation)
    {
        $unit = $this->unitTransformer->transformUnitToView($weatherStation->getPreferedUnit());
        $weatherStation = $this->weatherStationTransformer->transformWeatherStationToView($weatherStation);

        return new WeatherDataPeriodView(
            $weatherStation,
            $unit,
            $weatherData['temperature_max']['value'],
            $weatherData['temperature_max']['createdAt'],
            $weatherData['temperature_min']['value'],
            $weatherData['temperature_min']['createdAt'],
            $weatherData['humidex_max']['value'],
            $weatherData['humidex_max']['createdAt'],
            $weatherData['humidex_min']['value'],
            $weatherData['humidex_min']['createdAt'],
            $weatherData['dewpoint_max']['value'],
            $weatherData['dewpoint_max']['createdAt'],
            $weatherData['dewpoint_min']['value'],
            $weatherData['dewpoint_min']['createdAt'],
            $weatherData['windchill_max']['value'],
            $weatherData['windchill_max']['createdAt'],
            $weatherData['windchill_min']['value'],
            $weatherData['windchill_min']['createdAt'],
            $weatherData['humidity_max']['value'],
            $weatherData['humidity_max']['createdAt'],
            $weatherData['humidity_min']['value'],
            $weatherData['humidity_min']['createdAt'],
            $weatherData['relative_pressure_max']['value'],
            $weatherData['relative_pressure_max']['createdAt'],
            $weatherData['relative_pressure_min']['value'],
            $weatherData['relative_pressure_min']['createdAt'],
            $weatherData['rain_rate_max']['value'],
            $weatherData['rain_rate_max']['createdAt'],
            $weatherData['rain_event_max']['value'],
            $weatherData['rain_event_max']['createdAt'],
            $weatherData['rain_period']['value'],
            $weatherData['wind_gust_max']['value'],
            $weatherData['wind_gust_max']['createdAt'],
            $weatherData['beaufort_scale_max']['value'],
            $weatherData['beaufort_scale_max']['createdAt'],
            $weatherData['wind_speed_avg']['value'],
            round($weatherData['wind_dir_avg']['value']),
            round($weatherData['pm25_avg']['value']),
            round($weatherData['aqi_avg']['value']),
            $weatherData['pm25_max']['value'],
            $weatherData['pm25_max']['createdAt'],
            $weatherData['aqi_max']['value'],
            $weatherData['aqi_max']['createdAt'],
            $weatherData['solar_radiation_max']['value'],
            $weatherData['solar_radiation_max']['createdAt'],
            $weatherData['uv_max']['value'],
            $weatherData['uv_max']['createdAt'],
            $weatherData['pm25_min']['value'],
            $weatherData['pm25_min']['createdAt'],
            $weatherData['aqi_min']['value'],
            $weatherData['aqi_min']['createdAt'],
            $weatherData['cloud_base_min']['value'],
            $weatherData['cloud_base_min']['createdAt'],
            $weatherData['cloud_base_max']['value'],
            $weatherData['cloud_base_max']['createdAt'],
            $weatherData['heat_index_min']['value'],
            $weatherData['heat_index_min']['createdAt'],
            $weatherData['heat_index_max']['value'],
            $weatherData['heat_index_max']['createdAt']
        );
    }

    /**
     * @param WeatherStation $weatherStation
     * @param array $weatherDatas
     * @return WeatherDataGraphSearchView
     */
    public function transformWeatherDataGraphSearchView(WeatherStation $weatherStation, array $weatherDatas)
    {
        $unit = $this->unitTransformer->transformUnitToView($weatherStation->getPreferedUnit());
        $weatherStation = $this->weatherStationTransformer->transformWeatherStationToView($weatherStation);

        $datas = [];

        foreach ($weatherDatas as $weatherData) {
            $datas[] = $this->transformWeatherDataGraphView($weatherData);
        }

        return new WeatherDataGraphSearchView(
            $weatherStation,
            $unit,
            count($datas),
            $datas
        );
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
            $currentWeatherData->getWindDirectionAvg(),
            $currentWeatherData->getCreatedAt()
        );
    }

    /**
     * @param WeatherData $weatherData
     * @return WeatherDataGraphView
     */
    public function transformWeatherDataGraphView(WeatherData $weatherData)
    {
        return new WeatherDataGraphView(
            $weatherData->getId(),
            $weatherData->getTemperature(),
            $weatherData->getHumidity(),
            $weatherData->getRelativePressure(),
            $weatherData->getWindDirection(),
            $weatherData->getWindSpeed(),
            $weatherData->getWindGust(),
            $weatherData->getRainRate(),
            $weatherData->getRainDaily(),
            $weatherData->getRainWeekly(),
            $weatherData->getRainMonthly(),
            $weatherData->getRainYearly(),
            $weatherData->getSolarRadiation(),
            $weatherData->getUv(),
            $weatherData->getPm25(),
            $weatherData->getPm25Avg(),
            $weatherData->getDewPoint(),
            $weatherData->getWindChill(),
            $weatherData->getAqi(),
            $weatherData->getAqiAvg(),
            $weatherData->getCreatedAt()
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

        $temperatureVariation = $lastHourWeatherData ? round($currentWeatherData->getTemperature() - $lastHourWeatherData->getTemperature(), 1) : null;
        $relativePressureVariation = $lastHourWeatherData ? round($currentWeatherData->getRelativePressure() - $lastHourWeatherData->getRelativePressure(), 1) : null;
        $solarRadiationVariation = $lastHourWeatherData ? round($currentWeatherData->getSolarRadiation() - $lastHourWeatherData->getSolarRadiation(), 1) : null;
        $humidexVariation = $lastHourWeatherData ? round($currentWeatherData->getHumidex() - $lastHourWeatherData->getHumidex(), 1) : null;

        return new WeatherDataDetailView(
            $currentWeatherData->getId(),
            $weatherStation,
            $unit,
            $currentWeatherData->getTemperature(),
            $temperatureVariation,
            $currentWeatherData->getHumidity(),
            $currentWeatherData->getRelativePressure(),
            $relativePressureVariation,
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
            $solarRadiationVariation,
            $currentWeatherData->getUv(),
            $currentWeatherData->getPm25(),
            $currentWeatherData->getPm25Avg(),
            $currentWeatherData->getHumidex(),
            $humidexVariation,
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
