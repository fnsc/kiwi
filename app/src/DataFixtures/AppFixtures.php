<?php

namespace App\DataFixtures;

use App\Entity\PhoneNumber;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $user = new User();
         $user->setFirstName('John');
         $user->setLastName('Doe');
         $user->setEmail('johnDoe@gmail.com');

         $phoneNumber = new PhoneNumber();
         $phoneNumber->setUser($user);
         $phoneNumber->setName('mobile');
         $phoneNumber->setValue('9999999999');

         $manager->persist($user);
         $manager->flush();
         $manager->persist($phoneNumber);
         $manager->flush();

         $user = new User();
         $user->setFirstName('Rick');
         $user->setLastName('Martin');
         $user->setEmail('rickMartin@gmail.com');

         $manager->persist($user);
         $manager->flush();
    }
}
