<?php

namespace App\Presenters\Transformers;

use App\Entity\User as UserEntity;

class UserListTransformer
{
    public function __construct(
        private readonly User $userTransformer,
        private readonly PhoneNumber $phoneNumberTransformer,
        private readonly Address $addressTransformer
    ) {
    }

    public function transform(UserEntity $user): array
    {
        $transformedUser = $this->userTransformer->transform($user);
        $transformedPhoneNumbers = $this->getTransformedPhoneNumbers($user);
        $transformedAddress = $this->getTransformedAddress($user);

        return [
            ...$transformedUser,
            'phone_numbers' => $transformedPhoneNumbers,
            'address' => $transformedAddress
        ];
    }

    /**
     * @param UserEntity $user
     * @return array
     */
    private function getTransformedPhoneNumbers(UserEntity $user): array
    {
        $phoneNumbers = $user->getPhoneNumbers();

        if (empty($phoneNumbers)) {
            return [];
        }

        $transformedPhoneNumbers = [];

        foreach ($phoneNumbers as $phoneNumber) {
            $transformedPhoneNumbers[] = $this->phoneNumberTransformer->transform($phoneNumber);
        }

        return $transformedPhoneNumbers;
    }

    /**
     * @param UserEntity $user
     * @return array
     */
    private function getTransformedAddress(UserEntity $user): array
    {
        $address = $user->getAddress();

        if (empty($address)) {
            return [];
        }

        return $this->addressTransformer->transform($address);
    }
}