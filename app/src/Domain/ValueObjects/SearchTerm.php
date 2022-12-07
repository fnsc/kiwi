<?php

namespace App\Domain\ValueObjects;

class SearchTerm
{
    public function __construct(private readonly string $term)
    {
    }

    public function getTerm(): string
    {
        return $this->term;
    }
}