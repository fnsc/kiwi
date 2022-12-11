<?php

namespace App\Domain\ValueObjects;

class Filter
{
    public function __construct(
        private readonly string $name,
        private readonly string $value
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}