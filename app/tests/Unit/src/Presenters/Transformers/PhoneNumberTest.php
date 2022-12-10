<?php

namespace App\Tests\Unit\src\Presenters\Transformers;

use App\Entity\PhoneNumber as PhoneNumberEntity;
use App\Presenters\Transformers\PhoneNumber as PhoneNumberTransformer;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    public function testShouldTransformTheGivenPhoneNumber(): void
    {
        // Set
        $phoneNumber = m::mock(PhoneNumberEntity::class);
        $transformer = new PhoneNumberTransformer();

        $expected = [
            'name' => 'Mobile',
            'value' => '9999999999'
        ];

        // Expectations
        $phoneNumber->expects()
            ->getValue()
            ->andReturn('9999999999');

        $phoneNumber->expects()
            ->getName()
            ->andReturn('mobile');

        // Action
        $result = $transformer->transform($phoneNumber);

        // Assertions
        $this->assertSame($expected, $result);
    }
}