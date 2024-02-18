<?php

namespace App\Repository\Doctrine;

use App\Core\Constant\WeatherData\Period;
use App\Core\Converter\Period\PeriodConverter;
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
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qb
            ->andWhere('weatherStation.reference = :reference')
            ->andWhere(
                $qb->expr()->between('weatherData.date', ':startDate', ':endDate')
            )
            ->orderBy('weatherData.createdAt', 'DESC')
            ->setParameter('reference', $reference)
            ->setParameter('startDate', (new \DateTime())->modify('-7 day')->format('Y-m-d'))
            ->setParameter('endDate', (new \DateTime())->format('Y-m-d'));

        return $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    /**
     * @param string $reference
     * @return float|int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastInsertedLightningDataByWeatherStationReference(string $reference)
    {

        $qb = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qb
            ->andWhere('weatherStation.reference = :reference')
            ->andWhere(
                $qb->expr()->isNotNull('weatherData.lightningDate')
            )
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
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qb
            ->andWhere('weatherStation.reference = :reference')
            ->andWhere('weatherData.createdAt <= :dateStart')
            ->andWhere('weatherData.createdAt >= :dateEnd')
            ->andWhere(
                $qb->expr()->between('weatherData.date', ':startDate', ':endDate')
            )
            ->orderBy('weatherData.createdAt', 'DESC')
            ->setParameter('reference', $reference)
            ->setParameter('dateStart', (new \DateTime())->modify('-1 hours')->format('Y-m-d H:i:s'))
            ->setParameter('dateEnd', (new \DateTime())->modify('-2 hours')->format('Y-m-d H:i:s'))
            ->setParameter('startDate', (new \DateTime())->modify('-1 day')->format('Y-m-d'))
            ->setParameter('endDate', (new \DateTime())->format('Y-m-d'));

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
        $ttl = PeriodConverter::convertPeriodToTtl($period);

        // Temperature and Humidity history
        $history['temperature_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'temperature');
        $history['temperature_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'temperature');
        $history['humidex_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'humidex');
        $history['humidex_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'humidex');
        $history['dewpoint_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'dewPoint');
        $history['dewpoint_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'dewPoint');
        $history['windchill_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'windChill');
        $history['windchill_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'windChill');
        $history['humidity_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'humidity');
        $history['humidity_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'humidity');
        $history['heat_index_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'heatIndex');
        $history['heat_index_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'heatIndex');

        // Pressure history
        $history['relative_pressure_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'relativePressure');
        $history['relative_pressure_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'relativePressure');

        // Rain history
        $history['rain_rate_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'rainRate');
        $history['rain_event_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'rainEvent');

        $history['rain_period'] = [ 'value' => null, 'createdAt' => null ];
        if ($period !== Period::RECORD) {
            $history['rain_period'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, sprintf('%s%s', 'rain', ucfirst($period)));
        }

        // Wind speed
        $history['wind_gust_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'windGust');
        $history['beaufort_scale_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'beaufortScale');

        // Air quality
        $history['pm25_avg'] = $this->findAvgWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'pm25Avg');
        $history['aqi_avg'] = $this->findAvgWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'aqiAvg');
        $history['pm25_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'pm25');
        $history['aqi_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'aqi');
        $history['pm25_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'pm25');
        $history['aqi_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'aqi');

        // Solar radiation and UV
        $history['solar_radiation_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'solarRadiation');
        $history['uv_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'uv');

        // Optionnal sensors
        $history['soil_temperature_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'soilTemperature');
        $history['soil_temperature_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'soilTemperature');
        $history['leaf_wetness_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, $ttl, 'leafWetness');

        // Check data
        $history['has_data'] = $this->hasWeatherDataHistory($startDate, $endDate, $reference, $ttl);

        return $history;
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $period
     * @param string $reference
     * @return int|mixed|string
     */
    public function findWeatherDataGraph(string $startDate, string $endDate, string $period, string $reference)
    {
        $ttl = PeriodConverter::convertPeriodToTtl($period);
        $mod = PeriodConverter::convertPeriodToMod($period);

        $qb = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qb
            ->andWhere(
                $qb->expr()->between('weatherData.date', ':startDate', ':endDate')
            )
            ->andWhere('MOD(INT(EXTRACT(MINUTE FROM weatherData.createdAt)), :mod) = 0')
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('weatherData.createdAt', 'ASC')
            ->setParameter('mod', $mod)
            ->setParameter('startDate', \DateTime::createFromFormat('Y-m-d H:i:s', $startDate)->format('Y-m-d'))
            ->setParameter('endDate', \DateTime::createFromFormat('Y-m-d H:i:s', $endDate)->format('Y-m-d'))
            ->setParameter('reference', $reference);

        return $qb
            ->getQuery()
            ->useQueryCache(true)
            ->enableResultCache($ttl)
            ->getResult();
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $reference
     * @param int $ttl
     * @param string $field
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function findMaxWeatherDataHistory(string $startDate, string $endDate, string $reference, int $ttl, string $field)
    {
        $qb = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qb
            ->select('weatherData.createdAt, ' . $this->alias($field, 'weatherData', 'value'))
            ->andWhere(
                $qb->expr()->between('weatherData.date', ':startDate', ':endDate')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->andWhere($qb->expr()->isNotNull($this->alias($field, 'weatherData')))
            ->orderBy('value', 'DESC')
            ->setParameter('startDate', \DateTime::createFromFormat('Y-m-d H:i:s', $startDate)->format('Y-m-d'))
            ->setParameter('endDate', \DateTime::createFromFormat('Y-m-d H:i:s', $endDate)->format('Y-m-d'))
            ->setParameter('reference', $reference);

        return $qb
            ->getQuery()
            ->useQueryCache(true)
            ->enableResultCache($ttl)
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $reference
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function hasWeatherDataHistory(string $startDate, string $endDate, string $reference, int $ttl)
    {

        $qbSub = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qbSub
            ->select('weatherData.id')
            ->where(
                $qbSub->expr()->between('weatherData.date', ':startDate', ':endDate')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('weatherData.createdAt', 'ASC');

        $qb = $this
            ->createQueryBuilder('existQB');

        return $qb
            ->select($qb->expr()->count('existQB.id') . ' AS exist')
            ->where($qb->expr()->exists($qbSub->getDQL()))
            ->setParameter('startDate', \DateTime::createFromFormat('Y-m-d H:i:s', $startDate)->format('Y-m-d'))
            ->setParameter('endDate', \DateTime::createFromFormat('Y-m-d H:i:s', $endDate)->format('Y-m-d'))
            ->setParameter('reference', $reference)
            ->getQuery()
            ->useQueryCache(true)
            ->enableResultCache($ttl)
            ->getOneOrNullResult();
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function findWeatherDatas()
    {
        return $this
            ->createQueryBuilder('weatherData')
            ->andWhere('weatherData.id IS NOT NULL')
            ->getQuery();
    }

    /**
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCountWeatherDatas()
    {
        return $this
            ->createQueryBuilder('weatherData')
            ->select('COUNT(weatherData.id) AS numberOfResult')
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $reference
     * @param int $ttl
     * @param string $field
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function findAvgWeatherDataHistory(string $startDate, string $endDate, string $reference, int $ttl, string $field)
    {
        $qb = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qb
            ->select($qb->expr()->avg($this->alias($field, 'weatherData')) . ' AS value')
            ->andWhere(
                $qb->expr()->between('weatherData.date', ':startDate', ':endDate')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->setParameter('startDate', \DateTime::createFromFormat('Y-m-d H:i:s', $startDate)->format('Y-m-d'))
            ->setParameter('endDate', \DateTime::createFromFormat('Y-m-d H:i:s', $endDate)->format('Y-m-d'))
            ->setParameter('reference', $reference);

        return $qb
            ->getQuery()
            ->useQueryCache(true)
            ->enableResultCache($ttl)
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $reference
     * @param int $ttl
     * @param string $field
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function findMinWeatherDataHistory(string $startDate, string $endDate, string $reference, int $ttl, string $field)
    {
        $qb = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qb
            ->select('weatherData.createdAt, ' . $this->alias($field, 'weatherData', 'value'))
            ->andWhere(
                $qb->expr()->between('weatherData.date', ':startDate', ':endDate')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->andWhere($qb->expr()->isNotNull($this->alias($field, 'weatherData')))
            ->orderBy('value', 'ASC')
            ->setParameter('startDate', \DateTime::createFromFormat('Y-m-d H:i:s', $startDate)->format('Y-m-d'))
            ->setParameter('endDate', \DateTime::createFromFormat('Y-m-d H:i:s', $endDate)->format('Y-m-d'))
            ->setParameter('reference', $reference);

        return $qb
            ->getQuery()
            ->useQueryCache(true)
            ->enableResultCache($ttl)
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
