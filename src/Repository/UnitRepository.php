<?php

namespace App\Repository;

interface UnitRepository
{
    public function findByType(string $type);
}
