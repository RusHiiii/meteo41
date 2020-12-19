<?php


namespace App\Repository;


interface ContactRepository
{
    public function findByEmailSpamming(string $email);
}