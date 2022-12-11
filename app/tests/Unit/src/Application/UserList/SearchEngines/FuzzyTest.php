<?php

namespace App\Tests\Unit\src\Application\UserList\SearchEngines;

use App\Application\UserList\SearchEngines\Fuzzy;
use App\Domain\ValueObjects\Filter;
use App\Entity\User;
use App\Repository\UserRepository;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class FuzzyTest extends TestCase
{
    public function testShouldMakeASearch(): void
    {
        // Set
        $userRepository = $this->createMock(UserRepository::class);
        $fuzzyEngine = new Fuzzy($userRepository);
        $searchTerm = new Filter('john doe');

        $user = m::mock(User::class);
        $expected = [$user];

        // Expectations
        $userRepository->expects($this->once())
            ->method('findBySearchTerm')
            ->with([new Filter('john'), new Filter('doe')])
            ->willReturn([$user]);

        // Action
        $result = $fuzzyEngine->find($searchTerm);

        // Assertions
        $this->assertSame($expected, $result);
        $this->assertInstanceOf(User::class, current($result));
    }
}