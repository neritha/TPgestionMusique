<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create("fr_FR");

        $fichierArtisteCsv=fopen(__DIR__."/artiste.csv","r");
        $manager->flush();
    }
}
