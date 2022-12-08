<?php

namespace App\Application\UserList;

use App\Entity\User;

class OutputBoundary
{
    public function __construct(private readonly array|User $users)
    {
    }

    /**
     * @return array|User
     */
    public function getUsers(): array|User
    {
        return $this->users;
    }
}