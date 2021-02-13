<?php

namespace App\Core\Transformer;

use App\Entity\Core\ViewModels\Post\PostView;
use App\Entity\WebApp\Post;

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
