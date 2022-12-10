<?php

namespace App\Tests\Unit\src\Presenters\Transformers;

use App\Entity\Address as AddressEntity;
use App\Entity\PhoneNumber as PhoneNumberEntity;
use App\Entity\User as UserEntity;
use App\Presenters\Transformers\Address as AddressTransformer;
use App\Presenters\Transformers\PhoneNumber as PhoneNumberTransformer;
use App\Presenters\Transformers\User as UserTransformer;
use App\Presenters\Transformers\UserListTransformer;
use Doctrine\Common\Collections\Collection;
use Iterator;
use Mockery as m;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;

class UserListTransformerTest extends TestCase
{
    public function testShouldTransformTheGivenData(): void
    {
        // Set
        $userTransformer = $this->createMock(UserTransformer::class);
        $phoneNumberTransformer = $this->createMock(PhoneNumberTransformer::class);
        $addressTransformer = $this->createMock(AddressTransformer::class);
        $transformer = new UserListTransformer($userTransformer, $phoneNumberTransformer, $addressTransformer);

        $userEntity = m::mock(UserEntity::class);
        $phoneNumberEntity = m::mock(PhoneNumberEntity::class);
        $addressEntity = m::mock(AddressEntity::class);

        $phoneNumberCollection = m::mock(Collection::class);
        $phoneNumberIterator = $this->mockIterator($this->createMock(Iterator::class), [$phoneNumberEntity]);

        $expected = [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'johnDoe@gmail.com',
            'phone_numbers' => [
                [
                    'name' => 'Mobile',
                    'value' => '9999999999',
                ],
            ],
            'address' => [
                'address_line_1' => '505-900 Seymour St',
                'address_line_2' => null,
                'city' => 'Vancouver',
                'province' => 'BC',
                'country' => 'Canada',
                'zip_code' => 'V0T3Y9',
            ]
        ];

        // Expectations
        $userEntity->expects()
            ->getPhoneNumbers()
            ->andReturn($phoneNumberCollection);

        $phoneNumberCollection->expects()
            ->getIterator()
            ->andReturn($phoneNumberIterator);

        $userEntity->expects()
            ->getAddress()
            ->andReturn($addressEntity);
        
        $userTransformer->expects($this->once())
            ->method('transform')
            ->with($userEntity)
            ->willReturn([
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'johnDoe@gmail.com',
            ]);

        $phoneNumberTransformer->expects($this->once())
            ->method('transform')
            ->with($phoneNumberEntity)
            ->willReturn([
                'name' => 'Mobile',
                'value' => '9999999999'
            ]);
        
        $addressTransformer->expects($this->once())
            ->method('transform')
            ->with()
            ->willReturn([
                'address_line_1' => '505-900 Seymour St',
                'address_line_2' => null,
                'city' => 'Vancouver',
                'province' => 'BC',
                'country' => 'Canada',
                'zip_code' => 'V0T3Y9',
            ]);

        // Action
        $result = $transformer->transform($userEntity);

        // Assertions
        $this->assertSame($expected, $result);
    }

    private function mockIterator(MockObject $iteratorMock, array $items): MockObject
    {
        $iteratorData = new stdClass();
        $iteratorData->array = $items;
        $iteratorData->position = 0;

        $iteratorMock->expects($this->any())
                     ->method('rewind')
                     ->will(
                         $this->returnCallback(
                             function() use ($iteratorData) {
                                 $iteratorData->position = 0;
                             }
                         )
                     );

        $iteratorMock->expects($this->any())
                     ->method('current')
                     ->will(
                         $this->returnCallback(
                             function() use ($iteratorData) {
                                 return $iteratorData->array[$iteratorData->position];
                             }
                         )
                     );

        $iteratorMock->expects($this->any())
                     ->method('next')
                     ->will(
                         $this->returnCallback(
                             function() use ($iteratorData) {
                                 $iteratorData->position++;
                             }
                         )
                     );

        $iteratorMock->expects($this->any())
                     ->method('valid')
                     ->will(
                         $this->returnCallback(
                             function() use ($iteratorData) {
                                 return isset($iteratorData->array[$iteratorData->position]);
                             }
                         )
                     );

        return $iteratorMock;
    }
}