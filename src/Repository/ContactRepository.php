<?php

namespace App\Repository;

interface ContactRepository
{
    public function findByEmailSpamming(string $email);

    public function findPaginatedContacts(array $searchBy, string $order, int $page, int $maxResult);
}
