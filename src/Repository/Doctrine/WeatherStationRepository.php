<?php

namespace App\Repository\Doctrine;

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

    /**
     * @param string $country
     * @param string $address
     * @param string $city
     * @return int|mixed|string|null
     */
    public function findDuplicated(string $country, string $address, string $city)
    {
        $qb = $this
            ->createQueryBuilder('weatherStation')
            ->andWhere('weatherStation.country = :country')
            ->andWhere('weatherStation.address = :address')
            ->andWhere('weatherStation.city = :city')
            ->setParameter('address', $address)
            ->setParameter('city', $city)
            ->setParameter('country', $country);

        return $qb
            ->getQuery()
            ->getResult();
    }
}
