<?php

namespace App\Application\Filters\Country;

class OutputBoundary
{
    public function __construct(private readonly array $addresses)
    {
    }

    /**
     * @return array
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }
}