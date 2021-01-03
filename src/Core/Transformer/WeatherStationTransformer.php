<?php

namespace App\Core\Transformer;

use App\Entity\Core\ViewModels\WeatherStation\WeatherStationSearchView;
use App\Entity\Core\ViewModels\WeatherStation\WeatherStationView;
use App\Entity\WebApp\WeatherStation;
use Doctrine\ORM\Tools\Pagination\Paginator;

class WeatherStationTransformer
{
    /**
     * @param Paginator $paginator
     * @return WeatherStationSearchView
     */
    public function transformWeatherStationToSearchView(Paginator $paginator)
    {
        $weatherStations = [];

        foreach ($paginator as $weatherStation) {
            $weatherStations[] = $this->transformWeatherStationToView($weatherStation);
        }

        return new WeatherStationSearchView(
            $paginator->count(),
            $weatherStations
        );
    }

    /**
     * @param WeatherStation $weatherStation
     * @return WeatherStationView
     */
    public function transformWeatherStationToView(WeatherStation $weatherStation)
    {
        return new WeatherStationView(
            $weatherStation->getId(),
            $weatherStation->getName(),
            $weatherStation->getDescription(),
            $weatherStation->getShortDescription(),
            $weatherStation->getCountry(),
            $weatherStation->getAddress(),
            $weatherStation->getCity(),
            $weatherStation->getLat(),
            $weatherStation->getLng(),
            $weatherStation->getModel(),
            $weatherStation->getElevation(),
            $weatherStation->getCreatedAt(),
            $weatherStation->getUpdatedAt()
        );
    }
}
