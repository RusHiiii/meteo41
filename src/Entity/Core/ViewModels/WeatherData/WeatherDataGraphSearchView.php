<?php

namespace App\Entity\Core\ViewModels\WeatherData;

use App\Entity\Core\ViewModels\Unit\UnitView;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationView;

class WeatherDataGraphSearchView
{
    private int $numberOfResult;

    private WeatherStationView $weatherStation;

    private UnitView $unit;

    private array $datas;

    /**
     * WeatherDataGraphSearchView constructor.
     * @param WeatherStationView $weatherStation
     * @param UnitView $unit
     * @param int $numberOfResult
     * @param array $datas
     */
    public function __construct(WeatherStationView $weatherStation, UnitView $unit, int $numberOfResult, array $datas)
    {
        $this->weatherStation = $weatherStation;
        $this->unit = $unit;
        $this->datas = $datas;
        $this->numberOfResult = $numberOfResult;
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
     * @return int
     */
    public function getNumberOfResult(): int
    {
        return $this->numberOfResult;
    }

    /**
     * @return array
     */
    public function getDatas(): array
    {
        return $this->datas;
    }
}
