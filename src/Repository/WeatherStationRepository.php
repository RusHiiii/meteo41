<?php

namespace App\Repository;

interface WeatherStationRepository
{
    public function findDuplicated(string $country, string $address, string $city);

    public function findPaginatedWeatherStations(array $searchBy, string $order, int $page, int $maxResult);

    public function findByPasskey(string $passkey);
}
