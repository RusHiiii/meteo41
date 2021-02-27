<?php

namespace App\Core\Tactician\Handler\WeatherData;

use App\Core\Calculator\AqiCalculator;
use App\Core\Calculator\BeaufortScaleCalculator;
use App\Core\Converter\PressureConverter;
use App\Core\Converter\RainfallConverter;
use App\Core\Converter\TemperatureConverter;
use App\Core\Converter\WindSpeedConverter;
use App\Core\Exception\WeatherStation\WeatherStationNotFoundException;
use App\Core\Tactician\Command\WeatherData\RegisterWeatherDataCommand;
use App\Repository\Doctrine\WeatherStationRepository;
use Doctrine\ORM\EntityManagerInterface;

class RegisterWeatherDataHandler
{
    /**
     * @var WeatherStationRepository
     */
    private $weatherStationRepository;

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
     * RegisterWeatherDataHandler constructor.
     * @param WeatherStationRepository $weatherStationRepository
     * @param EntityManagerInterface $entityManager
     * @param TemperatureConverter $temperatureConverter
     * @param PressureConverter $pressureConverter
     * @param WindSpeedConverter $windSpeedConverter
     * @param RainfallConverter $rainfallConverter
     * @param BeaufortScaleCalculator $beaufortScaleCalculator
     * @param AqiCalculator $aqiCalculator
     */
    public function __construct(
        WeatherStationRepository $weatherStationRepository,
        EntityManagerInterface $entityManager,
        TemperatureConverter $temperatureConverter,
        PressureConverter $pressureConverter,
        WindSpeedConverter $windSpeedConverter,
        RainfallConverter $rainfallConverter,
        BeaufortScaleCalculator $beaufortScaleCalculator,
        AqiCalculator $aqiCalculator
    ) {
        $this->weatherStationRepository = $weatherStationRepository;
        $this->entityManager = $entityManager;
        $this->temperatureConverter = $temperatureConverter;
        $this->pressureConverter = $pressureConverter;
        $this->windSpeedConverter = $windSpeedConverter;
        $this->rainfallConverter = $rainfallConverter;
        $this->beaufortScaleCalculator = $beaufortScaleCalculator;
        $this->aqiCalculator = $aqiCalculator;
    }

    public function handle(RegisterWeatherDataCommand $command)
    {
        $weatherStation = $this->weatherStationRepository->find($command->getWeatherStationId());
        if ($weatherStation === null) {
            throw new WeatherStationNotFoundException();
        }

        // Calcul des données
        //TODO

        // Conversion si besoin
        //TODO

        // Persist + Assembler
        //TODO
    }
}
