<?php

namespace App\Entity\Core\ViewModels\User;

class UserSearchView
{
    private int $numberOfResult;

    private array $users;

    /**
     * UserSearchView constructor.
     * @param int $numberOfResult
     * @param array $users
     */
    public function __construct(int $numberOfResult, array $users)
    {
        $this->numberOfResult = $numberOfResult;
        $this->users = $users;
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
    public function getUsers(): array
    {
        return $this->users;
    }
}
