<?php

namespace App\Tests\Unit\src\Application\UserList\SearchEngines;

use App\Application\UserList\SearchEngines\Fuzzy;
use App\Application\UserList\SearchEngines\SearchEnginesManager;
use App\Domain\ValueObjects\SearchTerm;
use App\Entity\User;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class SearchEnginesManagerTest extends TestCase
{
    public function testShould(): void
    {
        // Set
        $fuzzy = $this->createMock(Fuzzy::class);
        $searchEngineManager = new SearchEnginesManager($fuzzy);

        $searchTerm = new SearchTerm('john doe');

        // Expectations
        $fuzzy->expects($this->once())
            ->method('find')
            ->with($searchTerm)
            ->willReturn([m::mock(User::class)]);
        
        // Action
        $result = $searchEngineManager->search($searchTerm);
        
        // Assertions
        $this->assertInstanceOf(User::class, current($result));
    }
}