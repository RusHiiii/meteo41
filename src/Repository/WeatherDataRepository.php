<?php

namespace App\Repository;

interface WeatherDataRepository
{
    public function findDuplicated(\DateTime $dateTime);

    public function findLastInsertedByWeatherStationReference(string $reference);

    public function findLastHourByWeatherStationReference(string $reference);

    public function findWeatherDataHistory(string $startDate, string $endDate, string $period, string $reference);
}
