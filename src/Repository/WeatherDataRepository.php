<?php

namespace App\Repository;

interface WeatherDataRepository
{
    public function findDuplicated(\DateTime $dateTime);
}
