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
}
