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
        ];
    }
}