<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\PhoneNumber;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 100; $i++) {
            $user = $this->getUser($faker);
            $phoneNumber = $this->getPhoneNumber($user, $faker);
            $address = $this->getAddress($user, $faker);

            $this->persist($manager, $user);

            if (rand(0, 1) === 1) {
                $this->persist($manager, $phoneNumber);
            }

            if (rand(0, 1) === 1) {
                $this->persist($manager, $address);
            }
        }

        $user = $this->getUser($faker, 'Rick', 'Martin');
        $phoneNumber = $this->getPhoneNumber($user, $faker);
        $address = $this->getAddress($user, $faker);
        $this->persist($manager, $user);
        $this->persist($manager, $phoneNumber);
        $this->persist($manager, $address);

        $user = $this->getUser($faker, 'Eric', 'Martin');
        $phoneNumber = $this->getPhoneNumber($user, $faker);
        $address = $this->getAddress($user, $faker);
        $this->persist($manager, $user);
        $this->persist($manager, $phoneNumber);
        $this->persist($manager, $address);
    }

    /**
     * @param Generator $faker
     * @param string $name
     * @param string $lastName
     * @return User
     */
    public function getUser(Generator $faker, string $name = '', string $lastName = ''): User
    {
        $user = new User();
        $user->setFirstName($name ?: $faker->firstName);
        $user->setLastName($lastName ?: $faker->lastName);
        $user->setEmail($faker->email);

        return $user;
    }

    /**
     * @param User $user
     * @param Generator $faker
     * @return PhoneNumber
     */
    public function getPhoneNumber(User $user, Generator $faker): PhoneNumber
    {
        $phoneNumber = new PhoneNumber();
        $phoneNumber->setUser($user);
        $phoneNumber->setName($faker->randomElement(['mobile', 'home', 'work']));
        $phoneNumber->setValue($faker->phoneNumber);
        return $phoneNumber;
    }

    /**
     * @param User $user
     * @param Generator $faker
     * @return Address
     */
    private function getAddress(User $user, Generator $faker): Address
    {
        $address = new Address();
        $address->setUser($user);
        $address->setAddressLine1($faker->streetAddress);
        $address->setAddressLine2($faker->buildingNumber);
        $address->setCity($faker->city);
        $address->setProvince($faker->word);
        $address->setCountry($faker->country);
        $address->setZipCode($faker->postcode);
        return $address;
    }

    /**
     * @param ObjectManager $manager
     * @param User $entity
     * @return void
     */
    private function persist(ObjectManager $manager, mixed $entity): void
    {
        $manager->persist($entity);
        $manager->flush();
    }
}
