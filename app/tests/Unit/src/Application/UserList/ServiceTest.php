<?php

namespace App\Tests\Unit\src\Application\UserList;

use App\Application\UserList\InputBoundary;
use App\Application\UserList\OutputBoundary;
use App\Application\UserList\SearchEngines\SearchEnginesManager;
use App\Application\UserList\Service;
use App\Domain\ValueObjects\Filter;
use App\Entity\User;
use Exception;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    public function testShouldHandle(): void
    {
        // Set
        $searchEngineManager = $this->createMock(SearchEnginesManager::class);
        $input = new InputBoundary('john');
        $searchTerm = new Filter('john');
        $service = new Service($searchEngineManager);
        $user = new User();
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('johnDoe@gmail.com');

        // Expectations
        $searchEngineManager->expects($this->once())
            ->method('search')
            ->with($searchTerm)
            ->willReturn([$user]);

        // Action
        $result = $service->handle($input);

        // Assertions
        $user = $result->getUsers()[0];
        $this->assertInstanceOf(OutputBoundary::class, $result);
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('John', $user->getFirstName());
    }

    public function testShouldThrowAnExceptionWhenRepositoryFails(): void
    {
        // Set
        $searchEngineManager = $this->createMock(SearchEnginesManager::class);
        $input = new InputBoundary('john');
        $searchTerm = new Filter('john');
        $service = new Service($searchEngineManager);
        $user = new User();
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('johnDoe@gmail.com');
        $exception = new Exception('Something unexpected');

        // Expectations
        $searchEngineManager->expects($this->once())
            ->method('search')
            ->with($searchTerm)
            ->willThrowException($exception);

        $this->expectException(Exception::class);

        // Action
        $service->handle($input);
    }
}