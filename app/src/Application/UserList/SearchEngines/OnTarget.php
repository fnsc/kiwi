<?php

namespace App\Application\UserList\SearchEngines;

use App\Domain\ValueObjects\SearchTerm;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;

class OnTarget
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @param SearchTerm $searchTerm
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function find(SearchTerm $searchTerm): ?User
    {
        return $this->userRepository->findExact($searchTerm);
    }
}