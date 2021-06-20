<?php

namespace App\Repository\Doctrine;

use App\Core\Constant\Observation\ApiSearch;
use App\Entity\WebApp\Observation;
use App\Repository\ObservationRepository as ObservationRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ObservationRepository extends AbstractRepository implements ObservationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Observation::class);
    }

    /**
     * @param array $searchBy
     * @param string $order
     * @param int $page
     * @param int $maxResult
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function findPaginatedObservation(array $searchBy, string $order, int $page, int $maxResult)
    {
        $qb = $this
            ->createQueryBuilder('observation');

        return $this
            ->addSearchBy($qb, $searchBy)
            ->addOrderBy($qb, $order)
            ->getPaginatedResult($qb, $page, $maxResult);
    }

    /**
     * @param string $reference
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLastObservationByWeatherStationReference(string $reference)
    {
        $qb = $this
            ->createQueryBuilder('observation')
            ->leftJoin('observation.weatherStation', 'weatherStation')
            ->andWhere('weatherStation.reference = :reference')
            ->andWhere('observation.updatedAt >= :dateStart')
            ->andWhere('observation.updatedAt <= :dateEnd')
            ->orderBy('observation.updatedAt', 'DESC')
            ->setParameter('reference', $reference)
            ->setParameter('dateStart', (new \DateTime())->modify('-12 hours')->format('Y-m-d H:i:s'))
            ->setParameter('dateEnd', (new \DateTime())->modify('+1 hours')->format('Y-m-d H:i:s'));

        return $qb
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
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
                case ApiSearch::OBSERVATION_SEARCH_BY_WEATHER_STATION:
                    $qb
                        ->andWhere('observation.weatherStation = :station')
                        ->setParameter('station', $value);
                    break;
                case ApiSearch::OBSERVATION_SEARCH_BY_MESSAGE:
                    $qb
                        ->andWhere('observation.message LIKE :message')
                        ->setParameter('message', sprintf('%%%s%%', $value));
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
        if (!in_array($order, [ApiSearch::OBSERVATION_ORDER_BY_ASC, ApiSearch::OBSERVATION_ORDER_BY_DESC])) {
            throw new \InvalidArgumentException('Order not valid');
        }

        $qb
            ->addOrderBy('observation.id', $order);

        return $this;
    }
}
