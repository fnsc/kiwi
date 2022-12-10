<?php

namespace App\Application\UserList\SearchEngines;

use App\Domain\ValueObjects\SearchTerm;
use App\Entity\User;

class SearchEnginesManager
{
    public function __construct(private readonly Fuzzy $fuzzy)
    {
    }

    /**
     * @param SearchTerm $searchTerm
     * @return array
     */
    public function search(SearchTerm $searchTerm): array
    {
        return $this->fuzzy->find($searchTerm);
    }
}