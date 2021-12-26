<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Departement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $departement = ["Direction", "RH", "Dev", "Com", "Design"];

        $faker = Factory::create('fr_FR');

        foreach ($departement as $dp) {
            $departement = new Departement;

            $departement->setName($dp);
            $departement->setResponsable($faker->email()); // Bon ici j'ai mis mon email pour tester l'envoie de mail

            $manager->persist($departement);
        }

        $manager->flush();
    }
}
