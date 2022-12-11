<?php

namespace App\Application\UserList;

class InputBoundary
{
    public function __construct(
        private readonly string $term,
        private readonly string $country
    ) {
    }

    public function getTerm(): string
    {
        return $this->term;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }
}