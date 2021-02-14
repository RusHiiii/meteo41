<?php

namespace App\Entity\Core\ViewModels\Post;

class PostSearchView
{
    private int $numberOfResult;

    private array $posts;

    /**
     * PostSearchView constructor.
     * @param int $numberOfResult
     * @param array $posts
     */
    public function __construct(int $numberOfResult, array $posts)
    {
        $this->numberOfResult = $numberOfResult;
        $this->posts = $posts;
    }

    /**
     * @return int
     */
    public function getNumberOfResult(): int
    {
        return $this->numberOfResult;
    }

    /**
     * @return array
     */
    public function getPosts(): array
    {
        return $this->posts;
    }
}
