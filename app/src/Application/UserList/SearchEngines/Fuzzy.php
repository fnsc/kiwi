<?php

namespace App\Application\UserList\SearchEngines;

use App\Domain\ValueObjects\Filter;
use App\Repository\UserRepository;

class Fuzzy
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function find(array $filters): array
    {
        $country = null;

        foreach ($filters as $filter) {
            if ('country' === $filter->getName() && !empty($filter->getValue())) {
                $country = $filter;
            }
        }

        $searchTerms = $this->getSearchTerms($filters[0]);

        if (!empty($country)) {
            return $this->userRepository->findBySearchTermAndCountry($searchTerms, $country);
        }

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
        return new Filter('term', $term);
    }
}