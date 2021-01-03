<?php

namespace App\Entity\Core\ViewModels\WeatherStation;

class WeatherStationSearchView
{
    private int $numberOfResult;

    private array $weatherStations;

    /**
     * WeatherStationSearchView constructor.
     * @param int $numberOfResult
     * @param array $weatherStations
     */
    public function __construct(int $numberOfResult, array $weatherStations)
    {
        $this->numberOfResult = $numberOfResult;
        $this->weatherStations = $weatherStations;
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
    public function getWeatherStations(): array
    {
        return $this->weatherStations;
    }
}
