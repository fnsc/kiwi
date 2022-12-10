<?php

namespace App\Tests\Unit\src\Application\UserList\SearchEngines;

use App\Application\UserList\SearchEngines\Fuzzy;
use App\Domain\ValueObjects\SearchTerm;
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
        $searchTerm = new SearchTerm('john doe');

        $user = m::mock(User::class);
        $expected = [$user];

        // Expectations
        $userRepository->expects($this->once())
            ->method('findBySearchTerm')
            ->with([new SearchTerm('john'), new SearchTerm('doe')])
            ->willReturn([$user]);

        // Action
        $result = $fuzzyEngine->find($searchTerm);

        // Assertions
        $this->assertSame($expected, $result);
        $this->assertInstanceOf(User::class, current($result));
    }
}