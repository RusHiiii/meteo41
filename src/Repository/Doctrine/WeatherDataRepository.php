<?php

namespace App\Repository\Doctrine;

use App\Core\Constant\WeatherData\Period;
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
            ->createQueryBuilder('weatherData');

        $qb
            ->leftJoin('weatherData.weatherStation', 'weatherStation')
            ->andWhere('weatherStation.reference = :reference')
            ->andWhere('weatherData.createdAt <= :dateStart')
            ->andWhere('weatherData.createdAt >= :dateEnd')
            ->andWhere(
                $qb->expr()->eq('weatherData.year', ':year')
            )
            ->andWhere(
                $qb->expr()->eq('weatherData.month', ':month')
            )
            ->andWhere(
                $qb->expr()->eq('weatherData.day', ':day')
            )
            ->orderBy('weatherData.createdAt', 'DESC')
            ->setParameter('reference', $reference)
            ->setParameter('year', date("Y", strtotime('now')))
            ->setParameter('month', date("m", strtotime('now')))
            ->setParameter('day', date("d", strtotime('now')))
            ->setParameter('dateStart', (new \DateTime())->modify('-1 hours')->format('Y-m-d H:i:s'))
            ->setParameter('dateEnd', (new \DateTime())->modify('-2 hours')->format('Y-m-d H:i:s'));

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
        $history['temperature_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'temperature');
        $history['temperature_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'temperature');
        $history['humidex_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'humidex');
        $history['humidex_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'humidex');
        $history['dewpoint_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'dewPoint');
        $history['dewpoint_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'dewPoint');
        $history['windchill_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'windChill');
        $history['windchill_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'windChill');
        $history['humidity_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'humidity');
        $history['humidity_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'humidity');
        $history['heat_index_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'heatIndex');
        $history['heat_index_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'heatIndex');

        // Pressure history
        $history['relative_pressure_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'relativePressure');
        $history['relative_pressure_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'relativePressure');

        // Rain history
        $history['rain_rate_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'rainRate');
        $history['rain_event_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'rainEvent');

        $history['rain_period'] = [ 'value' => null, 'createdAt' => null ];
        if ($period !== Period::RECORD) {
            $history['rain_period'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, sprintf('%s%s', 'rain', ucfirst($period)));
        }

        // Wind speed
        $history['wind_gust_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'windGust');
        $history['beaufort_scale_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'beaufortScale');
        $history['wind_speed_avg'] = $this->findAvgWeatherDataHistory($startDate, $endDate, $reference, 'windSpeedAvg');

        // Air quality
        $history['pm25_avg'] = $this->findAvgWeatherDataHistory($startDate, $endDate, $reference, 'pm25Avg');
        $history['aqi_avg'] = $this->findAvgWeatherDataHistory($startDate, $endDate, $reference, 'aqiAvg');
        $history['pm25_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'pm25');
        $history['aqi_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'aqi');
        $history['pm25_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'pm25');
        $history['aqi_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'aqi');

        // Solar radiation and UV
        $history['solar_radiation_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'solarRadiation');
        $history['uv_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'uv');

        // Cloud
        $history['cloud_base_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'cloudBase');
        $history['cloud_base_min'] = $this->findMinWeatherDataHistory($startDate, $endDate, $reference, 'cloudBase');

        // Check data
        $history['has_data'] = $this->hasWeatherDataHistory($startDate, $endDate, $reference);

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
        $mod = 1;

        if ($period === Period::WEEKLY) {
            $mod = 15;
        }

        if ($period === Period::MONTHLY) {
            $mod = 40;
        }

        if ($period === Period::YEARLY) {
            $mod = 180;
        }

        $qb = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qb
            ->andWhere(
                $qb->expr()->between('weatherData.year', ':startYear', ':endYear')
            )
            ->andWhere(
                $qb->expr()->between('weatherData.month', ':startMonth', ':endMonth')
            )
            ->andWhere(
                $qb->expr()->between('weatherData.day', ':startDay', ':endDay')
            )
            ->andWhere('MOD(weatherData.id, :mod) = 0')
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('weatherData.createdAt', 'ASC')
            ->setParameter('mod', $mod)
            ->setParameter('startYear', date("Y", strtotime($startDate)))
            ->setParameter('endYear', date("Y", strtotime($endDate)))
            ->setParameter('startMonth', date("m", strtotime($startDate)))
            ->setParameter('endMonth', date("m", strtotime($endDate)))
            ->setParameter('startDay', date("d", strtotime($startDate)))
            ->setParameter('endDay', date("d", strtotime($endDate)))
            ->setParameter('reference', $reference);

        return $qb
            ->getQuery()
            ->getResult();
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
            ->select('weatherData.createdAt, ' . $this->alias($field, 'weatherData', 'value'))
            ->andWhere(
                $qb->expr()->between('weatherData.year', ':startYear', ':endYear')
            )
            ->andWhere(
                $qb->expr()->between('weatherData.month', ':startMonth', ':endMonth')
            )
            ->andWhere(
                $qb->expr()->between('weatherData.day', ':startDay', ':endDay')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('value', 'DESC')
            ->setParameter('startYear', date("Y", strtotime($startDate)))
            ->setParameter('endYear', date("Y", strtotime($endDate)))
            ->setParameter('startMonth', date("m", strtotime($startDate)))
            ->setParameter('endMonth', date("m", strtotime($endDate)))
            ->setParameter('startDay', date("d", strtotime($startDate)))
            ->setParameter('endDay', date("d", strtotime($endDate)))
            ->setParameter('reference', $reference);

        return $qb
            ->getQuery()
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
    public function hasWeatherDataHistory(string $startDate, string $endDate, string $reference)
    {

        $qbSub = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qbSub
            ->select('weatherData.id')
            ->andWhere(
                $qbSub->expr()->between('weatherData.year', ':startYear', ':endYear')
            )
            ->andWhere(
                $qbSub->expr()->between('weatherData.month', ':startMonth', ':endMonth')
            )
            ->andWhere(
                $qbSub->expr()->between('weatherData.day', ':startDay', ':endDay')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('weatherData.createdAt', 'ASC');

        $qb = $this
            ->createQueryBuilder('existQB');

        return $qb
            ->select($qb->expr()->count('existQB.id') . ' AS exist')
            ->where($qb->expr()->exists($qbSub->getDQL()))
            ->setParameter('startYear', date("Y", strtotime($startDate)))
            ->setParameter('endYear', date("Y", strtotime($endDate)))
            ->setParameter('startMonth', date("m", strtotime($startDate)))
            ->setParameter('endMonth', date("m", strtotime($endDate)))
            ->setParameter('startDay', date("d", strtotime($startDate)))
            ->setParameter('endDay', date("d", strtotime($endDate)))
            ->setParameter('reference', $reference)
            ->getQuery()
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
     * @param string $field
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function findAvgWeatherDataHistory(string $startDate, string $endDate, string $reference, string $field)
    {
        $qb = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qb
            ->select($qb->expr()->avg($this->alias($field, 'weatherData')) . ' AS value')
            ->andWhere(
                $qb->expr()->between('weatherData.year', ':startYear', ':endYear')
            )
            ->andWhere(
                $qb->expr()->between('weatherData.month', ':startMonth', ':endMonth')
            )
            ->andWhere(
                $qb->expr()->between('weatherData.day', ':startDay', ':endDay')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('weatherData.createdAt', 'ASC')
            ->setParameter('startYear', date("Y", strtotime($startDate)))
            ->setParameter('endYear', date("Y", strtotime($endDate)))
            ->setParameter('startMonth', date("m", strtotime($startDate)))
            ->setParameter('endMonth', date("m", strtotime($endDate)))
            ->setParameter('startDay', date("d", strtotime($startDate)))
            ->setParameter('endDay', date("d", strtotime($endDate)))
            ->setParameter('reference', $reference);

        return $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
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
            ->select('weatherData.createdAt, ' . $this->alias($field, 'weatherData', 'value'))
            ->andWhere(
                $qb->expr()->between('weatherData.year', ':startYear', ':endYear')
            )
            ->andWhere(
                $qb->expr()->between('weatherData.month', ':startMonth', ':endMonth')
            )
            ->andWhere(
                $qb->expr()->between('weatherData.day', ':startDay', ':endDay')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('value', 'ASC')
            ->setParameter('startYear', date("Y", strtotime($startDate)))
            ->setParameter('endYear', date("Y", strtotime($endDate)))
            ->setParameter('startMonth', date("m", strtotime($startDate)))
            ->setParameter('endMonth', date("m", strtotime($endDate)))
            ->setParameter('startDay', date("d", strtotime($startDate)))
            ->setParameter('endDay', date("d", strtotime($endDate)))
            ->setParameter('reference', $reference);

        return $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
