<?php

namespace App\Presenters\Transformers;

use App\Entity\User as UserEntity;

class UserListTransformer
{
    public function __construct(
        private readonly User $userTransformer,
        private readonly PhoneNumber $phoneNumberTransformer,
        private readonly Address $addressTransformer
    )
    {
    }

    public function transform(UserEntity $user): array
    {
        $transformedUser = $this->userTransformer->transform($user);
        $phoneNumbers = $user->getPhoneNumbers();

        $transformedPhoneNumbers = [];

        foreach ($phoneNumbers as $phoneNumber) {
            $transformedPhoneNumbers[] = $this->phoneNumberTransformer->transform($phoneNumber);
        }

        $transformedAddress = $this->addressTransformer->transform($user->getAddress());

        return [
            ...$transformedUser,
            'phone_numbers' => $transformedPhoneNumbers,
            'address' => $transformedAddress
        ];
    }
}