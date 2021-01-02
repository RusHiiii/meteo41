<?php

namespace App\Repository;

interface UserRepository
{
    public function findByEmail(string $email);
}
