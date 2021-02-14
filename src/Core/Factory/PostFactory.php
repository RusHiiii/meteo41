<?php

namespace App\Core\Factory;

use App\Core\Tactician\Command\Post\EditPostCommand;
use App\Core\Tactician\Command\Post\RegisterPostCommand;
use App\Entity\WebApp\Post;
use App\Entity\WebApp\User;

class PostFactory
{
    /**
     * @param RegisterPostCommand $command
     * @param User $user
     * @return Post
     */
    public function createPostFromCommand(RegisterPostCommand $command, User $user)
    {
        $post = new Post(
            $command->getName(),
            $command->getDescription()
        );

        $post->setUser($user);

        return $post;
    }

    /**
     * @param Post $post
     * @param EditPostCommand $editPostCommand
     * @param User $user
     * @return Post
     */
    public function editPostFromCommand(Post $post, EditPostCommand $editPostCommand, User $user)
    {
        $post->setName($editPostCommand->getName());
        $post->setDescription($editPostCommand->getDescription());
        $post->setUser($user);
        $post->setUpdatedAt(new \DateTime());

        return $post;
    }
}
