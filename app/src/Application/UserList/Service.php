<?php

namespace App\Application\UserList;

use App\Application\UserList\SearchEngines\SearchEnginesManager;
use App\Domain\ValueObjects\Filter;

class Service
{
    public function __construct(private readonly SearchEnginesManager $searchEngine)
    {
    }

    /**
     * @param InputBoundary $input
     * @return OutputBoundary
     */
    public function handle(InputBoundary $input): OutputBoundary
    {
        $searchTerm = new Filter('term', $input->getTerm());
        $countryFilter = new Filter('country', $input->getCountry());
        $result = $this->searchEngine->search([$searchTerm, $countryFilter]);

        return new OutputBoundary($result);
    }
}