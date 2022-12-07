<?php

namespace App\Application\UserList;

class OutputBoundary
{
    public function __construct(private readonly array $users)
    {
    }

    public function getUsers(): array
    {
        return $this->users;
    }
}