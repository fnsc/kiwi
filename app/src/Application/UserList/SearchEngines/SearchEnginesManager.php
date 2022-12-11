<?php

namespace App\Application\UserList\SearchEngines;

use App\Domain\ValueObjects\Filter;
use App\Entity\User;

class SearchEnginesManager
{
    public function __construct(
        private readonly Fuzzy $fuzzy,
        private readonly OnTarget $onTarget
    ) {
    }

    /**
     * @param array $filters
     * @return array
     */
    public function search(array $filters): array
    {
        $onTargetResult = $this->onTarget->find($filters);
        $fuzzyResult = $this->fuzzy->find($filters);

        return $this->getUniqueResult([...$onTargetResult, ...$fuzzyResult]);
    }

    private function getUniqueResult(array $searchResults): array
    {
        $ids = array_map(function ($searchResult) {
            return $searchResult->getId();
        }, $searchResults);

        $uniqueIds = array_unique($ids);

        return array_values(array_intersect_key($searchResults, $uniqueIds));
    }
}