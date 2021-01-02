<?php

namespace App\Repository;

interface WeatherStationRepository
{
    public function findDuplicated(string $country, string $address, string $city);
}
