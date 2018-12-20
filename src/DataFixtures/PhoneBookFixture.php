<?php

namespace App\DataFixtures;

use App\Entity\PhoneBook;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PhoneBookFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for($i = 0; $i < 100; $i++) {
            $property = new PhoneBook();
            $property->setName($faker->firstNameMale());
            $property->setPhone($faker->phoneNumber());

            $user = $manager->getRepository(User::class)->find(1);
            $property->setUser($user);
            $manager->persist($property);
        }


        $manager->flush();
    }
}
