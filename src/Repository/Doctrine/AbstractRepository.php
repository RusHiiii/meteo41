<?php

namespace App\Repository\Doctrine;

use App\Entity\WebApp\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\ContactRepository as ContactRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    /**
     * @param mixed $queryBuilder
     * @param int $page
     * @param int $maxResult
     * @return Paginator
     */
    public function getPaginatedResult($queryBuilder, int $page, int $maxResult)
    {
        if (!$queryBuilder instanceof QueryBuilder) {
            throw new \InvalidArgumentException('Cannot create query builder');
        }

        $queryBuilder
            ->setMaxResults($maxResult)
            ->setFirstResult(($page - 1) * $maxResult);

        return new Paginator($queryBuilder);
    }

    /**
     * @param string $field
     * @param string $query
     * @param string|null $alias
     * @return string
     */
    public function alias(string $field, string $query, string $alias = null)
    {
        if ($alias === null) {
            return sprintf('%s.%s', $query, $field);
        }

        return sprintf('%s.%s AS %s', $query, $field, $alias);
    }
}
