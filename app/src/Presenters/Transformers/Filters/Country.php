<?php

namespace App\Presenters\Transformers\Filters;

use App\Entity\Address;

class Country
{
    public function transform(Address $address): array
    {
        return [
            'name' => $address->getCountry()
        ];
    }
}