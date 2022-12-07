<?php

namespace App\Application\UserList;

class InputBoundary
{
    public function __construct(private readonly string $term)
    {
    }

    public function getTerm(): string
    {
        return $this->term;
    }
}