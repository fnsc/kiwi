<?php

namespace App\Tests\Integration\src\Controller\Api;

use App\Controller\Api\UserListController;
use App\Entity\User;
use App\Tests\IntegrationTestCase;
use Mockery as m;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserListControllerTest extends IntegrationTestCase
{
    public function testShouldReceiveAListOfUsers(): void
    {
        // Set
        $user = $this->createUser();
        $this->storeEntity($user);

        $controller = static::getContainer()->get(UserListController::class);
        $request = m::mock(Request::class);

        $expected = [
            'users' => [
                [
                    'id' => 1,
                    'name' => 'John Doe',
                    'email' => 'johnDoe@gmail.com',
                    'phone_numbers' => [],
                    'address' => [],
                ],
            ],
        ];

        // Expectations
        $request->expects()
            ->get('term')
            ->andReturn('joh');

        // Action
        /** @var JsonResponse $result */
        $result = $controller->list($request);

        // Assertions
        $this->assertSame($expected, json_decode($result->getContent(), true));
        $this->assertSame(Response::HTTP_OK, $result->getStatusCode());
    }

    /**
     * @return User
     */
    private function createUser(): User
    {
        $user = new User();
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('johnDoe@gmail.com');

        return $user;
    }

    private function storeEntity(mixed $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}