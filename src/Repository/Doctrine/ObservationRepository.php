<?php

namespace App\Repository\Doctrine;

use App\Entity\WebApp\Observation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\ObservationRepository as ObservationRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class ObservationRepository extends ServiceEntityRepository implements ObservationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Observation::class);
    }
}
