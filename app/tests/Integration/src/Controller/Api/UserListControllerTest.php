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
        $user1 = $this->createUser('Eric', 'Martin', 'ericMartin@gmail.com');
        $user2 = $this->createUser('Rick', 'Martin', 'rickMartin@gmail.com');
        $user3 = $this->createUser();
        $user4 = $this->createUser('Erica', 'Martinez', 'ericaMartinez@gmail.com');
        $this->storeEntity($user1);
        $this->storeEntity($user2);
        $this->storeEntity($user3);
        $this->storeEntity($user4);

        $controller = static::getContainer()->get(UserListController::class);
        $request = m::mock(Request::class);

        $expected = [
            'users' => [
                [
                    'id' => 1,
                    'name' => 'Eric Martin',
                    'email' => 'ericMartin@gmail.com',
                    'phone_numbers' => [],
                    'address' => [],
                ],
                [
                    'id' => 4,
                    'name' => 'Erica Martinez',
                    'email' => 'ericaMartinez@gmail.com',
                    'phone_numbers' => [],
                    'address' => [],
                ],
                [
                    'id' => 2,
                    'name' => 'Rick Martin',
                    'email' => 'rickMartin@gmail.com',
                    'phone_numbers' => [],
                    'address' => [],
                ],
            ],
        ];

        // Expectations
        $request->expects()
            ->get('term')
            ->andReturn('eri mar');

        // Action
        /** @var JsonResponse $result */
        $result = $controller->list($request);

        // Assertions
        $this->assertSame($expected, json_decode($result->getContent(), true));
        $this->assertSame(Response::HTTP_OK, $result->getStatusCode());
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @return User
     */
    private function createUser(string $firstName = '', string $lastName = '', string $email = ''): User
    {
        $user = new User();
        $user->setFirstName($firstName ?: 'John');
        $user->setLastName($lastName ?: 'Doe');
        $user->setEmail($email ?: 'johnDoe@gmail.com');

        return $user;
    }

    private function storeEntity(mixed $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}