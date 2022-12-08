<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\PhoneNumber;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 100; $i++) {
             $user = new User();
             $user->setFirstName($faker->firstName);
             $user->setLastName($faker->lastName);
             $user->setEmail($faker->email);

             $phoneNumber = new PhoneNumber();
             $phoneNumber->setUser($user);
             $phoneNumber->setName($faker->randomElement(['mobile', 'home', 'work']));
             $phoneNumber->setValue($faker->phoneNumber);

             $address = new Address();
             $address->setUser($user);
             $address->setAddressLine1($faker->streetAddress);
             $address->setAddressLine2($faker->buildingNumber);
             $address->setCity($faker->city);
             $address->setProvince($faker->word);
             $address->setCountry($faker->country);
             $address->setZipCode($faker->postcode);


             $manager->persist($user);
             $manager->flush();

             if (rand(0, 1) === 1) {
                 $manager->persist($phoneNumber);
                 $manager->flush();
             }

             if (rand(0, 1) === 1) {
                 $manager->persist($address);
                 $manager->flush();
             }
        }
    }
}
