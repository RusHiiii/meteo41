<?php

namespace App\Core\Transformer;

use App\Entity\Core\ViewModels\Observation\ObservationSearchView;
use App\Entity\Core\ViewModels\Observation\ObservationView;
use App\Entity\WebApp\Observation;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ObservationTransformer
{
    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * @var WeatherStationTransformer
     */
    private $weatherStationTransformer;

    /**
     * ObservationTransformer constructor.
     * @param UserTransformer $userTransformer
     * @param WeatherStationTransformer $weatherStationTransformer
     */
    public function __construct(
        UserTransformer $userTransformer,
        WeatherStationTransformer $weatherStationTransformer
    ) {
        $this->userTransformer = $userTransformer;
        $this->weatherStationTransformer = $weatherStationTransformer;
    }

    /**
     * @param Paginator $paginator
     * @return ObservationSearchView
     */
    public function transformObservationToSearchView(Paginator $paginator)
    {
        $observations = [];

        foreach ($paginator as $observation) {
            $observations[] = $this->transformObservationToView($observation);
        }

        return new ObservationSearchView(
            $paginator->count(),
            $observations
        );
    }

    /**
     * @param Observation $observation
     * @return ObservationView
     */
    public function transformObservationToView(Observation $observation)
    {
        $user = $this->userTransformer->transformUserToView($observation->getUser());
        $weatherStation = $this->weatherStationTransformer->transformWeatherStationToView($observation->getWeatherStation());

        return new ObservationView(
            $observation->getId(),
            $observation->getMessage(),
            $observation->getCreatedAt(),
            $observation->getUpdatedAt(),
            $user,
            $weatherStation
        );
    }
}
