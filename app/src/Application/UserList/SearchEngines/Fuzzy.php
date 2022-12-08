<?php

namespace App\Application\UserList\SearchEngines;

use App\Domain\ValueObjects\SearchTerm;
use App\Repository\UserRepository;

class Fuzzy
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function find(SearchTerm $searchTerm): array
    {
        $terms = explode(' ', $searchTerm->getTerm());
        $searchTerms = [];

        foreach ($terms as $term) {
            $searchTerms[] = $this->buildSearchTerm($term);
        }

        return $this->userRepository->findBySearchTerm($searchTerms);
    }

    private function buildSearchTerm(string $term): SearchTerm
    {
        return new SearchTerm($term);
    }
}