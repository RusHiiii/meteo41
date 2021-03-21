<?php

namespace App\Repository\Doctrine;

use App\Entity\WebApp\WeatherData;
use App\Repository\WeatherDataRepository as WeatherDataRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class WeatherDataRepository extends AbstractRepository implements WeatherDataRepositoryInterface
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

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $period
     * @param string $reference
     * @return array
     */
    public function findWeatherDataHistory(string $startDate, string $endDate, string $period, string $reference)
    {
        $history = [];

        // Temperature and Humidity history
        $history['temperature_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'temperature');
        $history['temperature_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'temperature');
        $history['humidex_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'humidex');
        $history['humidex_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'humidex');
        $history['dewpoint_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'dewPoint');
        $history['dewpoint_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'dewPoint');
        $history['windchill_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'windChill');
        $history['windchill_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'windChill');
        $history['humidity_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'humidity');
        $history['humidity_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'humidity');

        // Pressure history
        $history['relative_pressure_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'relativePressure');
        $history['relative_pressure_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'relativePressure');

        // Rain history
        $history['rain_rate_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'rainRate');
        $history['rain_period'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, sprintf('%s%s', 'rain', ucfirst($period)));

        return $history;
    }

    /**
     * @param string $field
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function queryMaxWeatherDataHistory(string $field)
    {
        $subQb = $this
            ->createQueryBuilder('maxSubQuery')
            ->leftJoin('maxSubQuery.weatherStation', 'weatherStationSub');

        $subQb
            ->select($subQb->expr()->max($this->alias($field, 'maxSubQuery')))
            ->where(
                $subQb->expr()->between('maxSubQuery.createdAt', ':startDate', ':endDate')
            )
            ->andWhere('weatherStationSub.reference = :reference')
            ->orderBy('maxSubQuery.createdAt', 'ASC');

        return $subQb;
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $reference
     * @param string $field
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function findMaxWeatherDataHistory(string $startDate, string $endDate, string $reference, string $field)
    {
        $qb = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qb
            ->select($this->alias($field, 'weatherData') .  ', weatherData.createdAt')
            ->where(
                $qb->expr()->in($this->alias($field, 'weatherData'), $this->queryMaxWeatherDataHistory($field)->getDQL())
            )
            ->andWhere(
                $qb->expr()->between('weatherData.createdAt', ':startDate', ':endDate')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('weatherData.createdAt', 'ASC')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('reference', $reference);

        return $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    /**
     * @param string $field
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function queryMinWeatherDataHistory(string $field)
    {
        $subQb = $this
            ->createQueryBuilder('minSubQuery')
            ->leftJoin('minSubQuery.weatherStation', 'weatherStationSub');

        $subQb
            ->select($subQb->expr()->min($this->alias($field, 'minSubQuery')))
            ->where(
                $subQb->expr()->between('minSubQuery.createdAt', ':startDate', ':endDate')
            )
            ->andWhere('weatherStationSub.reference = :reference')
            ->orderBy('minSubQuery.createdAt', 'ASC');

        return $subQb;
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $reference
     * @param string $field
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function findMinWeatherDataHistory(string $startDate, string $endDate, string $reference, string $field)
    {
        $qb = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qb
            ->select($this->alias($field, 'weatherData') .  ', weatherData.createdAt')
            ->where(
                $qb->expr()->in($this->alias($field, 'weatherData'), $this->queryMinWeatherDataHistory($field)->getDQL())
            )
            ->andWhere(
                $qb->expr()->between('weatherData.createdAt', ':startDate', ':endDate')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('weatherData.createdAt', 'ASC')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('reference', $reference);

        return $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
