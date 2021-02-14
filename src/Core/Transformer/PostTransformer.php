<?php

namespace App\Core\Transformer;

use App\Entity\Core\ViewModels\Post\PostSearchView;
use App\Entity\Core\ViewModels\Post\PostView;
use App\Entity\WebApp\Post;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PostTransformer
{
    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * PostTransformer constructor.
     * @param UserTransformer $userTransformer
     */
    public function __construct(
        UserTransformer $userTransformer
    ) {
        $this->userTransformer = $userTransformer;
    }

    /**
     * @param Paginator $paginator
     * @return PostSearchView
     */
    public function transformPostToSearchView(Paginator $paginator)
    {
        $posts = [];

        foreach ($paginator as $post) {
            $posts[] = $this->transformPostToView($post);
        }

        return new PostSearchView(
            $paginator->count(),
            $posts
        );
    }

    public function transformPostToView(Post $post)
    {
        $user = $this->userTransformer->transformUserToView($post->getUser());

        return new PostView(
            $post->getId(),
            $post->getName(),
            $post->getCreatedAt(),
            $post->getUpdatedAt(),
            $post->getDescription(),
            $user
        );
    }
}
