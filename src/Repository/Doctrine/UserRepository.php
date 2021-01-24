<?php

namespace App\Repository\Doctrine;

use App\Core\Constant\User\ApiSearch;
use App\Entity\WebApp\User;
use App\Repository\UserRepository as UserRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $email
     * @return object|null
     */
    public function findByEmail(string $email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * @param array $searchBy
     * @param string $order
     * @param int $page
     * @param int $maxResult
     * @return mixed
     */
    public function findPaginatedUsers(array $searchBy, string $order, int $page, int $maxResult)
    {
        $qb = $this
            ->createQueryBuilder('user');

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
                case ApiSearch::USER_SEARCH_BY_EMAIL:
                    $qb
                        ->andWhere('user.email LIKE :email')
                        ->setParameter('email', sprintf('%%%s%%', $value));
                    break;
                case ApiSearch::USER_SEARCH_BY_ROLE:
                    $qb
                        ->andWhere('user.roles LIKE :role')
                        ->setParameter('role', sprintf('%%%s%%', $value));
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
        if (!in_array($order, [ApiSearch::USER_ORDER_BY_ASC, ApiSearch::USER_ORDER_BY_DESC])) {
            throw new \InvalidArgumentException('Order not valid');
        }

        $qb
            ->addOrderBy('user.id', $order);

        return $this;
    }
}
