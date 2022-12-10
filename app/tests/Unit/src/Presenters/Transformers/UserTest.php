<?php

namespace App\Tests\Unit\src\Presenters\Transformers;

use App\Entity\User as UserEntity;
use App\Presenters\Transformers\User as UserTransformer;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testShouldTransformTheGivenUser(): void
    {
        // Set
        $user = m::mock(UserEntity::class);
        $transformer = new UserTransformer();

        $expected = [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'johnDoe@gmail.com',
        ];

        // Expectations
        $user->expects()
            ->getId()
            ->andReturn(1);

        $user->expects()
            ->getFirstName()
            ->andReturn('John');

        $user->expects()
            ->getLastName()
            ->andReturn('Doe');

        $user->expects()
            ->getEmail()
            ->andReturn('johnDoe@gmail.com');

        // Action
        $result = $transformer->transform($user);

        // Assertions
        $this->assertSame($expected, $result);
    }
}