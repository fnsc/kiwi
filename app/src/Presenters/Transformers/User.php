<?php

namespace App\Presenters\Transformers;

use App\Entity\User as UserEntity;

class User
{
    public function transform(UserEntity $user): array
    {
        return [
            'name' => $user->getFirstName() . ' ' . $user->getLastName(),
            'email' => $user->getEmail(),
            'phone_numbers' => $this->getPhoneNumbers($user),
        ];
    }

    private function getPhoneNumbers(UserEntity $user): array
    {
        $result = [];

        foreach ($user->getPhoneNumbers() as $phoneNumber) {
            $result[$phoneNumber->getName()] = $phoneNumber->getValue();
        }

        return $result;
    }
}