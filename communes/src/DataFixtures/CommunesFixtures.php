<?php

namespace App\DataFixtures;

use App\Entity\Communes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommunesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("Fr-fr");

        for ($i = 0; $i < 20; $i++) {
            $communes = new Communes();
            $communes->setNom($faker->city);
            $communes->setCode($faker->numberBetween(10000, 100000));
            $communes->setCodeDepartement($faker->numberBetween(0,100));
            $communes->setCodeRegion($faker->numberBetween(0,100));
            $communes->setCodesPostaux($faker->numberBetween(10000,100000));
            $communes->setPopulation($faker->numberBetween(10000, 1000000));
            $manager->persist($communes);
        }

        $manager->flush();
    }
}
