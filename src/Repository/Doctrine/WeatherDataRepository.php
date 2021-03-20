<?php

namespace App\Repository\Doctrine;

use App\Entity\WebApp\WeatherData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\WeatherDataRepository as WeatherDataRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class WeatherDataRepository extends ServiceEntityRepository implements WeatherDataRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeatherData::class);
    }

    /**
     * @param \DateTime $dateTime
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findDuplicated(\DateTime $dateTime)
    {
        $qb = $this
            ->createQueryBuilder('weatherData')
            ->andWhere('weatherData.createdAt = :createdAt')
            ->setParameter('createdAt', $dateTime);

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $reference
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastInsertedByWeatherStationReference(string $reference)
    {

        $qb = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation')
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('weatherData.createdAt', 'DESC')
            ->setParameter('reference', $reference);

        return $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    /**
     * @param string $reference
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastHourByWeatherStationReference(string $reference)
    {
        $qb = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation')
            ->andWhere('weatherStation.reference = :reference')
            ->andWhere('weatherData.createdAt <= :date')
            ->orderBy('weatherData.createdAt', 'DESC')
            ->setParameter('reference', $reference)
            ->setParameter('date', (new \DateTime())->modify('-1 hours')->format('Y-m-d H:i:s'));

        return $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
