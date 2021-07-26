<?php

namespace App\Repository\Doctrine;

use App\Core\Constant\WeatherData\Period;
use App\Entity\WebApp\WeatherData;
use App\Repository\WeatherDataRepository as WeatherDataRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

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
            ->andWhere('weatherData.createdAt <= :dateStart')
            ->andWhere('weatherData.createdAt >= :dateEnd')
            ->orderBy('weatherData.createdAt', 'DESC')
            ->setParameter('reference', $reference)
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
        $history['wind_gust_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'windMaxDailyGust');
        $history['beaufort_scale_max'] = $this->findMaxWeatherDataHistory($startDate, $endDate, $reference, 'beaufortScale');
        $history['wind_speed_avg'] = $this->findAvgWeatherDataHistory($startDate, $endDate, $reference, 'windSpeedAvg');
        $history['wind_dir_avg'] = $this->findAvgWeatherDataHistory($startDate, $endDate, $reference, 'windDirectionAvg');

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
        $mod = 2;

        if ($period === Period::WEEKLY) {
            $mod = 10;
        }

        if ($period === Period::MONTHLY) {
            $mod = 30;
        }

        if ($period === Period::YEARLY) {
            $mod = 120;
        }

        $qb = $this
            ->createQueryBuilder('weatherData')
            ->leftJoin('weatherData.weatherStation', 'weatherStation');

        $qb
            ->andWhere(
                $qb->expr()->between('weatherData.createdAt', ':startDate', ':endDate')
            )
            ->andWhere('MOD(weatherData.id, :mod) = 0')
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('weatherData.createdAt', 'ASC')
            ->setParameter('mod', $mod)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
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
                $qb->expr()->between('weatherData.createdAt', ':startDate', ':endDate')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('value', 'DESC')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
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
            ->where(
                $qbSub->expr()->between('weatherData.createdAt', ':startDate', ':endDate')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('weatherData.createdAt', 'ASC');

        $qb = $this
            ->createQueryBuilder('existQB');

        return $qb
            ->select($qb->expr()->count('existQB.id'))
            ->where($qb->expr()->exists($qbSub->getDQL()))
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('reference', $reference)
            ->getQuery()
            ->getOneOrNullResult() !== null;
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
                $qb->expr()->between('weatherData.createdAt', ':startDate', ':endDate')
            )
            ->andWhere('weatherStation.reference = :reference')
            ->orderBy('value', 'ASC')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('reference', $reference);

        return $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
