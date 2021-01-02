<?php

namespace App\Repository\Doctrine;

use App\Entity\WebApp\Contact;
use App\Entity\WebApp\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\PostRepository as PostRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }
}
