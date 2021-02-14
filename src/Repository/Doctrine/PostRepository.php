<?php

namespace App\Repository\Doctrine;

use App\Core\Constant\Post\ApiSearch;
use App\Entity\WebApp\Post;
use App\Repository\PostRepository as PostRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends AbstractRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @param array $searchBy
     * @param string $order
     * @param int $page
     * @param int $maxResult
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function findPaginatedPosts(array $searchBy, string $order, int $page, int $maxResult)
    {
        $qb = $this
            ->createQueryBuilder('post')
            ->leftJoin('post.user', 'user');

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
                case ApiSearch::POST_SEARCH_BY_NAME:
                    $qb
                        ->andWhere('post.name LIKE :name')
                        ->setParameter('name', sprintf('%%%s%%', $value));
                    break;
                case ApiSearch::POST_SEARCH_BY_USER:
                    $qb
                        ->andWhere('user = :user')
                        ->setParameter('user', $value);
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
        if (!in_array($order, [ApiSearch::POST_ORDER_BY_ASC, ApiSearch::POST_ORDER_BY_DESC])) {
            throw new \InvalidArgumentException('Order not valid');
        }

        $qb
            ->addOrderBy('post.id', $order);

        return $this;
    }
}
