<?php

namespace App\Repository;

interface ObservationRepository
{
    public function findPaginatedObservation(array $searchBy, string $order, int $page, int $maxResult);

    public function findLastObservationByWeatherStationReference(string $reference);
}
