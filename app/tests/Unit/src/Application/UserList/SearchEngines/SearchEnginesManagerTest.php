<?php

namespace App\Tests\Unit\src\Application\UserList\SearchEngines;

use App\Application\UserList\SearchEngines\Fuzzy;
use App\Application\UserList\SearchEngines\OnTarget;
use App\Application\UserList\SearchEngines\SearchEnginesManager;
use App\Domain\ValueObjects\Filter;
use App\Entity\User;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class SearchEnginesManagerTest extends TestCase
{
    public function testShould(): void
    {
        // Set
        $fuzzy = $this->createMock(Fuzzy::class);
        $onTarget = $this->createMock(OnTarget::class);
        $searchEngineManager = new SearchEnginesManager($fuzzy, $onTarget);
        $user = m::mock(User::class);

        $searchTerm = new Filter('john doe');

        // Expectations
        $onTarget->expects($this->once())
            ->method('find')
            ->with($searchTerm)
            ->willReturn([$user]);

        $fuzzy->expects($this->once())
            ->method('find')
            ->with($searchTerm)
            ->willReturn([$user]);

        $user->expects()
            ->getId()
            ->twice()
            ->andReturn(1);
        
        // Action
        $result = $searchEngineManager->search($searchTerm);
        
        // Assertions
        $this->assertInstanceOf(User::class, current($result));
    }
}