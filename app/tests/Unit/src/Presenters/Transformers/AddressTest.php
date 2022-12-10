<?php

namespace App\Tests\Unit\src\Presenters\Transformers;

use App\Entity\Address as AddressEntity;
use App\Presenters\Transformers\Address as AddressTransformer;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testShouldTransformTheGivenAddress(): void
    {
        // Set
        $address = m::mock(AddressEntity::class);
        $transformer = new AddressTransformer();

        $expected = [
            'address_line_1' => '505-900 Seymour St',
            'address_line_2' => null,
            'city' => 'Vancouver',
            'province' => 'BC',
            'country' => 'Canada',
            'zip_code' => 'V0T3Y9',
        ];

        // Expectations
        $address->expects()
            ->getAddressLine1()
            ->andReturn('505-900 Seymour St');

        $address->expects()
            ->getAddressLine2()
            ->andReturnNull();

        $address->expects()
            ->getCity()
            ->andReturn('Vancouver');

        $address->expects()
            ->getProvince()
            ->andReturn('BC');

        $address->expects()
            ->getCountry()
            ->andReturn('Canada');

        $address->expects()
            ->getZipCode()
            ->andReturn('V0T3Y9');

        // Action
        $result = $transformer->transform($address);

        // Assertions
        $this->assertSame($expected, $result);
    }
}