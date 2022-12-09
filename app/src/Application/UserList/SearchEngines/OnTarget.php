<?php

namespace App\Application\UserList\SearchEngines;

use App\Domain\ValueObjects\SearchTerm;
use App\Repository\UserRepository;

class OnTarget
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    /**
     * @param SearchTerm $searchTerm
     * @return array
     */
    public function find(SearchTerm $searchTerm): array
    {
        return $this->userRepository->findExact($searchTerm);
    }
}