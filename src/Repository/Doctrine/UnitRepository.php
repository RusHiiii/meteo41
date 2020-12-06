<?php


namespace App\Repository\Doctrine;


use App\Entity\WebApp\Contact;
use App\Entity\WebApp\Unit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\UnitRepository as UnitRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class UnitRepository extends ServiceEntityRepository implements UnitRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unit::class);
    }
}