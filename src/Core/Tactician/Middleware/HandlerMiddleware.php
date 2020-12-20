<?php


namespace App\Core\Tactician\Middleware;

use Doctrine\ORM\EntityManagerInterface;
use League\Tactician\Middleware;

class HandlerMiddleware implements Middleware
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * HandlerMiddleware constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute($command, callable $next)
    {
        $next($command);
        $this->entityManager->flush();
    }
}