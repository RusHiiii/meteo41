<?php

namespace App\Repository;

interface UserRepository
{
    public function findByEmail(string $email);

    public function findPaginatedUsers(array $searchBy, string $order, int $page, int $maxResult);
}
