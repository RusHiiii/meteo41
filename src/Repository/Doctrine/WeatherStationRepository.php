<?php

namespace App\Repository\Doctrine;

use App\Core\Constant\WeatherStation\ApiSearch;
use App\Entity\WebApp\WeatherStation;
use App\Repository\WeatherStationRepository as WeatherStationRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class WeatherStationRepository extends AbstractRepository implements WeatherStationRepositoryInterface
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

    /**
     * @param string $passkey
     * @return int|mixed|string
     */
    public function findByPasskey(string $passkey)
    {
        $qb = $this
            ->createQueryBuilder('weatherStation')
            ->andWhere('weatherStation.apiToken = :token')
            ->setParameter('token', hash('sha256', $passkey));

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $ref
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByReference(string $ref)
    {
        $qb = $this
            ->createQueryBuilder('weatherStation')
            ->andWhere('weatherStation.reference = :ref')
            ->setParameter('ref', $ref);

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param array $searchBy
     * @param string $order
     * @param int $page
     * @param int $maxResult
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function findPaginatedWeatherStations(array $searchBy, string $order, int $page, int $maxResult)
    {
        $qb = $this
            ->createQueryBuilder('weatherStation');

        return $this
            ->addSearchBy($qb, $searchBy)
            ->addOrderBy($qb, $order)
            ->getPaginatedResult($qb, $page, $maxResult);
    }

    /**
     * @param QueryBuilder $qb
     * @param array $searchBy
     * @return $this
     */
    private function addSearchBy(QueryBuilder $qb, array $searchBy)
    {
        foreach ($searchBy as $key => $value) {
            switch ($key) {
                case ApiSearch::WEATHER_STATION_SEARCH_BY_COUNTRY:
                    $qb
                        ->andWhere('weatherStation.country = :country')
                        ->setParameter('country', $value);
                    break;
                case ApiSearch::WEATHER_STATION_SEARCH_BY_NAME:
                    $qb
                        ->andWhere('weatherStation.name LIKE :name')
                        ->setParameter('name', sprintf('%%%s%%', $value));
                    break;
                case ApiSearch::WEATHER_STATION_SEARCH_BY_REFERENCE:
                    $qb
                        ->andWhere('weatherStation.reference = :reference')
                        ->setParameter('reference', $value);
                    break;
                default:
                    throw new \InvalidArgumentException('Invalid search value');
            }
        }

        return $this;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $order
     * @return $this
     */
    private function addOrderBy(QueryBuilder $qb, string $order)
    {
        if (!in_array($order, [ApiSearch::WEATHER_STATION_ORDER_BY_ASC, ApiSearch::WEATHER_STATION_ORDER_BY_DESC])) {
            throw new \InvalidArgumentException('Order not valid');
        }

        $qb
            ->addOrderBy('weatherStation.id', $order);

        return $this;
    }
}
