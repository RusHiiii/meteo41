<?php

namespace App\Core\Tactician\Handler\WeatherData;

use App\Core\Calculator\AqiCalculator;
use App\Core\Calculator\BeaufortScaleCalculator;
use App\Core\Calculator\CloudBaseCalculator;
use App\Core\Calculator\DewPointCalculator;
use App\Core\Calculator\HeatIndexCalculator;
use App\Core\Calculator\HumidexCalculator;
use App\Core\Calculator\WindChillCalculator;
use App\Core\Converter\Weather\CloudBaseConverter;
use App\Core\Converter\Weather\PressureConverter;
use App\Core\Converter\Weather\RainfallConverter;
use App\Core\Converter\Weather\TemperatureConverter;
use App\Core\Converter\Weather\WindSpeedConverter;
use App\Core\Exception\WeatherData\WeatherDataAlreadyInsertedException;
use App\Core\Exception\WeatherStation\WeatherStationNotFoundException;
use App\Core\Factory\WeatherDataFactory;
use App\Core\Tactician\Command\WeatherData\RegisterWeatherDataCommand;
use App\Entity\WebApp\Unit;
use App\Entity\WebApp\WeatherData;
use App\Entity\WebApp\WeatherStation;
use App\Repository\Doctrine\WeatherDataRepository;
use App\Repository\Doctrine\WeatherStationRepository;
use Doctrine\ORM\EntityManagerInterface;

class RegisterWeatherDataHandler
{
    /**
     * @var WeatherStationRepository
     */
    private $weatherStationRepository;

    /**
     * @var WeatherDataRepository
     */
    private $weatherDataRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TemperatureConverter
     */
    private $temperatureConverter;

    /**
     * @var PressureConverter
     */
    private $pressureConverter;

    /**
     * @var WindSpeedConverter
     */
    private $windSpeedConverter;

    /**
     * @var RainfallConverter
     */
    private $rainfallConverter;

    /**
     * @var BeaufortScaleCalculator
     */
    private $beaufortScaleCalculator;

    /**
     * @var AqiCalculator
     */
    private $aqiCalculator;

    /**
     * @var DewPointCalculator
     */
    private $dewPointCalculator;

    /**
     * @var WindChillCalculator
     */
    private $windChillCalculator;

    /**
     * @var HeatIndexCalculator
     */
    private $heatIndexCalculator;

    /**
     * @var CloudBaseCalculator
     */
    private $cloudBaseCalculator;

    /**
     * @var CloudBaseConverter
     */
    private $cloudBaseConverter;

    /**
     * @var HumidexCalculator
     */
    private $humidexCalculator;

    /**
     * @var WeatherDataFactory
     */
    private $weatherDataFactory;

    /**
     * RegisterWeatherDataHandler constructor.
     * @param WeatherDataRepository $weatherDataRepository
     * @param WeatherStationRepository $weatherStationRepository
     * @param EntityManagerInterface $entityManager
     * @param TemperatureConverter $temperatureConverter
     * @param PressureConverter $pressureConverter
     * @param WindSpeedConverter $windSpeedConverter
     * @param RainfallConverter $rainfallConverter
     * @param BeaufortScaleCalculator $beaufortScaleCalculator
     * @param AqiCalculator $aqiCalculator
     * @param DewPointCalculator $dewPointCalculator
     * @param WindChillCalculator $windChillCalculator
     * @param HeatIndexCalculator $heatIndexCalculator
     * @param CloudBaseCalculator $cloudBaseCalculator
     * @param CloudBaseConverter $cloudBaseConverter
     * @param HumidexCalculator $humidexCalculator
     * @param WeatherDataFactory $weatherDataFactory
     */
    public function __construct(
        WeatherDataRepository $weatherDataRepository,
        WeatherStationRepository $weatherStationRepository,
        EntityManagerInterface $entityManager,
        TemperatureConverter $temperatureConverter,
        PressureConverter $pressureConverter,
        WindSpeedConverter $windSpeedConverter,
        RainfallConverter $rainfallConverter,
        BeaufortScaleCalculator $beaufortScaleCalculator,
        AqiCalculator $aqiCalculator,
        DewPointCalculator $dewPointCalculator,
        WindChillCalculator $windChillCalculator,
        HeatIndexCalculator $heatIndexCalculator,
        CloudBaseCalculator $cloudBaseCalculator,
        CloudBaseConverter $cloudBaseConverter,
        HumidexCalculator $humidexCalculator,
        WeatherDataFactory $weatherDataFactory
    ) {
        $this->weatherStationRepository = $weatherStationRepository;
        $this->entityManager = $entityManager;
        $this->temperatureConverter = $temperatureConverter;
        $this->pressureConverter = $pressureConverter;
        $this->windSpeedConverter = $windSpeedConverter;
        $this->rainfallConverter = $rainfallConverter;
        $this->beaufortScaleCalculator = $beaufortScaleCalculator;
        $this->aqiCalculator = $aqiCalculator;
        $this->dewPointCalculator = $dewPointCalculator;
        $this->windChillCalculator = $windChillCalculator;
        $this->weatherDataRepository = $weatherDataRepository;
        $this->heatIndexCalculator = $heatIndexCalculator;
        $this->cloudBaseCalculator = $cloudBaseCalculator;
        $this->cloudBaseConverter = $cloudBaseConverter;
        $this->humidexCalculator = $humidexCalculator;
        $this->weatherDataFactory = $weatherDataFactory;
    }

    public function handle(RegisterWeatherDataCommand $command)
    {
        $weatherStation = $this->weatherStationRepository->find($command->getWeatherStationId());
        if ($weatherStation === null) {
            throw new WeatherStationNotFoundException();
        }

        $weatherData = $this->weatherDataRepository->findDuplicated($command->getDate());
        if ($weatherData !== null) {
            throw new WeatherDataAlreadyInsertedException();
        }

        /** @var WeatherData $lastWeatherData */
        $lastWeatherData = $this->weatherDataRepository->findLastInsertedByWeatherStationReference($weatherStation->getReference());

        /**
         * Basic weather station data
         */
        $temperature = $command->getOutdoorTemperatureF();
        $relativePressure = $command->getRelativePressureInhg();
        $absolutePressure = $command->getAbsolutePressureInhg();
        $windSpeed = $command->getWindSpeedMph();
        $windSpeedAvg = $command->getAverageWindSpeedMph10m();
        $windGust = $command->getWindGustMph();
        $windMaxDailyGust = $command->getMaxDailyGustMph();
        $rainRate = $command->getRainRateInch();
        $rainEvent = $command->getEventRainInch();
        $rainHourly = $command->getHourlyRainInch();
        $rainDaily = $command->getDailyRainInch();
        $rainWeekly = $command->getWeeklyRainInch();
        $rainMonthly = $command->getMonthlyRainInch();
        $rainYearly = $command->getYearlyRainInch();

        /**
         * External sensors soil + leaf wetness
         */
        $soilTemperature = $command->getSoilTemperatureF();
        $leafWetness = $command->getLeafWetness();

        /**
         * External lightning sensor
         */
        $lastLighningDate = null;
        $lastLighningDistance = null;
        if ($command->getLightningTime()) {
            $lastLighningDateReceived = \DateTime::createFromFormat('U', $command->getLightningTime());
            if ($lastLighningDateReceived > $lastWeatherData->getLightningDate()) {
                $lastLighningDate = $lastLighningDateReceived;
                $lastLighningDistance = $command->getLightning();
            }
        }

        /**
         * Calculated weather station data
         */
        $dewPoint = $this->dewPointCalculator->getDewPoint($temperature, $command->getHumidity());
        $humidex = $this->humidexCalculator->getHumidex($temperature, $dewPoint);
        $windChill = $this->windChillCalculator->getWindChill($temperature, $windSpeed);
        $cloudBase = $this->cloudBaseCalculator->getCloudBase($temperature, $dewPoint);
        $heatIndex = $this->heatIndexCalculator->getHeatIndex($temperature, $command->getHumidity());
        $beaufortScale = $this->beaufortScaleCalculator->getBeaufortScale($windSpeed);

        $aqi = $this->aqiCalculator->getAqi($command->getPm25());
        $aqiAvg = $this->aqiCalculator->getAqi($command->getAveragePm25Days());

        /**
         * Convert data if needed
         */
        if ($weatherStation->getPreferedUnit()->getType() === Unit::UNIT_METRIC) {
            $temperature = $this->temperatureConverter->convertImperialToMetric($temperature);
            $relativePressure = $this->pressureConverter->convertImperialToMetric($relativePressure);
            $absolutePressure = $this->pressureConverter->convertImperialToMetric($absolutePressure);
            $windSpeed = $this->windSpeedConverter->convertImperialToMetric($windSpeed);
            $windSpeedAvg = $this->windSpeedConverter->convertImperialToMetric($windSpeedAvg);
            $windGust = $this->windSpeedConverter->convertImperialToMetric($windGust);
            $windMaxDailyGust = $this->windSpeedConverter->convertImperialToMetric($windMaxDailyGust);
            $rainRate = $this->rainfallConverter->convertImperialToMetric($rainRate);
            $rainEvent = $this->rainfallConverter->convertImperialToMetric($rainEvent);
            $rainHourly = $this->rainfallConverter->convertImperialToMetric($rainHourly);
            $rainDaily = $this->rainfallConverter->convertImperialToMetric($rainDaily);
            $rainWeekly = $this->rainfallConverter->convertImperialToMetric($rainWeekly);
            $rainMonthly = $this->rainfallConverter->convertImperialToMetric($rainMonthly);
            $rainYearly = $this->rainfallConverter->convertImperialToMetric($rainYearly);

            $dewPoint = $this->temperatureConverter->convertImperialToMetric($dewPoint);
            $windChill = $this->temperatureConverter->convertImperialToMetric($windChill);
            $cloudBase = $this->cloudBaseConverter->convertImperialToMetric($cloudBase);
            $heatIndex = $this->temperatureConverter->convertImperialToMetric($heatIndex);

            $soilTemperature = $this->temperatureConverter->convertImperialToMetric($soilTemperature);
        }

        $weatherData = $this->weatherDataFactory->createWeatherDataFromCommand($command, $heatIndex, $temperature, $relativePressure, $absolutePressure, $windSpeed, $windSpeedAvg, $windGust, $windMaxDailyGust, $rainRate, $rainEvent, $rainHourly, $rainDaily, $rainWeekly, $rainMonthly, $rainYearly, $humidex, $dewPoint, $windChill, $cloudBase, $beaufortScale, $aqi, $aqiAvg, $leafWetness, $soilTemperature, $lastLighningDistance, $lastLighningDate, $weatherStation->getPreferedUnit(), $weatherStation);
        $this->entityManager->persist($weatherData);
    }
}
