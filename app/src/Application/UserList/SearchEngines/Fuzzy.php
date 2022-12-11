<?php

namespace App\Application\UserList\SearchEngines;

use App\Domain\ValueObjects\Filter;
use App\Repository\UserRepository;

class Fuzzy
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function find(Filter $searchTerm): array
    {
        $searchTerms = $this->getSearchTerms($searchTerm);

        return $this->userRepository->findBySearchTerm($searchTerms);
    }

    private function getSearchTerms(Filter $searchTerm): array
    {
        $searchTerms = [];
        $terms = explode(' ', $searchTerm->getValue());

        foreach ($terms as $term) {
            $searchTerms[] = $this->buildSearchTerm($term);
        }

        return $searchTerms;
    }

    private function buildSearchTerm(string $term): Filter
    {
        return new Filter($term);
    }
}