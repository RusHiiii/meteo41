<?php

namespace App\Repository;

interface PostRepository
{
    public function findPaginatedPosts(array $searchBy, string $order, int $page, int $maxResult);
}
