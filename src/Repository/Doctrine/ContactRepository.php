<?php


namespace App\Repository\Doctrine;


use App\Entity\WebApp\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\ContactRepository as ContactRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class ContactRepository extends ServiceEntityRepository implements ContactRepositoryInterface
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
}