<?php

namespace App\Tests\Unit\src\Application\UserList;

use App\Application\UserList\InputBoundary;
use App\Application\UserList\OutputBoundary;
use App\Application\UserList\Service;
use App\Domain\ValueObjects\SearchTerm;
use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    public function testShouldHandle(): void
    {
        // Set
        $userRepository = $this->createMock(UserRepository::class);
        $input = new InputBoundary('john');
        $searchTerm = new SearchTerm('john');
        $service = new Service($userRepository);
        $user = new User();
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('johnDoe@gmail.com');

        // Expectations
        $userRepository->expects($this->once())
            ->method('findBySearchTerm')
            ->with($searchTerm)
            ->willReturn([$user]);

        // Action
        $result = $service->handle($input);

        // Assertions
        $user = current($result->getUsers());
        $this->assertInstanceOf(OutputBoundary::class, $result);
        $this->assertInstanceOf(User::class, $result->getUsers()[0]);
        $this->assertSame('John', $user->getFirstName());
    }

    public function testShouldThrowAnExceptionWhenRepositoryFails(): void
    {
        // Set
        $userRepository = $this->createMock(UserRepository::class);
        $input = new InputBoundary('john');
        $searchTerm = new SearchTerm('john');
        $service = new Service($userRepository);
        $user = new User();
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('johnDoe@gmail.com');
        $exception = new Exception('Something unexpected');

        // Expectations
        $userRepository->expects($this->once())
            ->method('findBySearchTerm')
            ->with($searchTerm)
            ->willThrowException($exception);

        $this->expectException(Exception::class);

        // Action
        $service->handle($input);
    }
}