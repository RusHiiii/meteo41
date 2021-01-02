<?php

namespace App\Repository\Doctrine;

use App\Core\Constant\Contact\ApiSearch;
use App\Entity\WebApp\Contact;
use App\Repository\ContactRepository as ContactRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ContactRepository extends AbstractRepository implements ContactRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * @param string $email
     * @return array
     */
    public function findByEmailSpamming(string $email)
    {
        $qb = $this
            ->createQueryBuilder('contact')
            ->andWhere('contact.email = :email')
            ->andWhere('contact.createdAt > :date')
            ->setParameter('date', (new \DateTime())->modify('-1 day'))
            ->setParameter('email', $email);

        return $qb
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $searchBy
     * @param string $order
     * @param int $page
     * @param int $maxResult
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function findPaginatedContacts(array $searchBy, string $order, int $page, int $maxResult)
    {
        $qb = $this
            ->createQueryBuilder('contact');

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
                case ApiSearch::CONTACT_SEARCH_BY_EMAIL:
                    $qb
                        ->andWhere('contact.email LIKE :email')
                        ->setParameter('email', sprintf('%%%s%%', $value));
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
        if (!in_array($order, [ApiSearch::CONTACT_ORDER_BY_ASC, ApiSearch::CONTACT_ORDER_BY_DESC])) {
            throw new \InvalidArgumentException('Order not valid');
        }

        $qb
            ->addOrderBy('contact.id', $order);

        return $this;
    }
}
