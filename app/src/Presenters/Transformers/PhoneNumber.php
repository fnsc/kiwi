<?php

namespace App\Presenters\Transformers;

use App\Entity\PhoneNumber as PhoneNumberEntity;

class PhoneNumber
{
    public function transform(?PhoneNumberEntity $phoneNumber): array
    {
        if (empty($phoneNumber)) {
            return [];
        }

        return [
            'name' => ucfirst(strtolower($phoneNumber->getName())),
            'value'=> $phoneNumber->getValue()
        ];
    }
}