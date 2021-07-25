<?php

namespace App\Entity\Core\ViewModels\WeatherData;

use App\Entity\Core\ViewModels\Unit\UnitView;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationView;

class WeatherDataGraphSearchView
{
    private int $numberOfResult;

    private WeatherStationView $weatherStation;

    private UnitView $unit;

    private \DateTime $dateBegin;

    private \DateTime $dateEnd;

    private array $datas;

    /**
     * WeatherDataGraphSearchView constructor.
     * @param WeatherStationView $weatherStation
     * @param UnitView $unit
     * @param int $numberOfResult
     * @param \DateTime $dateBegin
     * @param \DateTime $dateEnd
     * @param array $datas
     */
    public function __construct(WeatherStationView $weatherStation, UnitView $unit, int $numberOfResult, \DateTime $dateBegin, \DateTime $dateEnd, array $datas)
    {
        $this->weatherStation = $weatherStation;
        $this->unit = $unit;
        $this->datas = $datas;
        $this->numberOfResult = $numberOfResult;
        $this->dateBegin = $dateBegin;
        $this->dateEnd = $dateEnd;
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

    /**
     * @return \DateTime
     */
    public function getDateBegin(): \DateTime
    {
        return $this->dateBegin;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd(): \DateTime
    {
        return $this->dateEnd;
    }
}
