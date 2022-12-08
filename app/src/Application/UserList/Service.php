<?php

namespace App\Application\UserList;

use App\Application\UserList\SearchEngines\SearchEnginesManager;
use App\Domain\ValueObjects\SearchTerm;

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
        $searchTerm = new SearchTerm($input->getTerm());
        $result = $this->searchEngine->search($searchTerm);

        return new OutputBoundary($result);
    }
}