<?php

namespace App\Application\UserList;

use App\Domain\ValueObjects\SearchTerm;
use App\Repository\UserRepository;

class Service
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $searchTerm = new SearchTerm($input->getTerm());
        $result = $this->userRepository->findBySearchTerm($searchTerm);

        return new OutputBoundary($result);
    }
}