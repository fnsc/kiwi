<?php

namespace App\Application\UserList\SearchEngines;

use App\Domain\ValueObjects\Filter;
use App\Repository\UserRepository;

class OnTarget
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @param array<Filter> $filters
     * @return array
     */
    public function find(array $filters): array
    {
        $hasCountryFilter = false;

        foreach ($filters as $filter) {
            if ('country' === $filter->getName() && !empty($filter->getValue())) {
                $hasCountryFilter = true;
            }
        }


        if (!$hasCountryFilter) {
            $filterByTerm = array_filter($filters, function ($filter) {
                return $filter->getName() === 'term';
            });

            return $this->userRepository->findExact($filterByTerm[0]);
        }

        return $this->userRepository->findExactWithCountry($filters);
    }
}