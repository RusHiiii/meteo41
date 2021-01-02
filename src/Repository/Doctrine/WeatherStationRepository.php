<?php

namespace App\Repository\Doctrine;

use App\Entity\WebApp\Contact;
use App\Entity\WebApp\WeatherStation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\WeatherStationRepository as WeatherStationRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class WeatherStationRepository extends ServiceEntityRepository implements WeatherStationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeatherStation::class);
    }
}
