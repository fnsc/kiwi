<?php

namespace App\Presenters\Transformers;

use App\Entity\Address as AddressEntity;

class Address
{
    public function transform(?AddressEntity $address): array
    {
        if (empty($address)) {
            return [];
        }

        return [
            'address_line_1' => $address->getAddressLine1(),
            'address_line_2' => $address->getAddressLine2(),
            'city' => $address->getCity(),
            'province' => $address->getProvince(),
            'country' => $address->getCountry(),
            'zip_code' => $address->getZipCode(),
        ];
    }
}