<?php

namespace App\Application\Filters\Country;

use App\Repository\AddressRepository;

class Service
{
    public function __construct(private readonly AddressRepository $addressRepository)
    {
    }

    public function handle(): OutputBoundary
    {
        $result = $this->addressRepository->findByUniqueCountries();

        return new OutputBoundary($result);
    }
}