<?php

namespace App\Core\Tactician\Handler\Post;

use App\Core\Exception\Post\PostNotFoundException;
use App\Core\Tactician\Command\Post\DeletePostCommand;
use App\Repository\Doctrine\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeletePostHandler
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * DeletePostHandler constructor.
     * @param PostRepository $postRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        PostRepository $postRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->postRepository = $postRepository;
        $this->entityManager = $entityManager;
    }

    public function handle(DeletePostCommand $postCommand)
    {
        $post = $this->postRepository->find($postCommand->getId());
        if ($post === null) {
            throw new PostNotFoundException();
        }

        $this->entityManager->remove($post);
    }
}
