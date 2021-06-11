<?php

namespace App\DataFixtures;

use Faker\Factory;
use Nelmio\Alice\Loader\NativeLoader;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_BE');

        $loader = new NativeLoader($faker);

        //importe le fichier de fixtures et récupère les entités générés
        $entities = $loader->loadFile(__DIR__ . '/fixtures.yaml')->getObjects();

        //empile la liste d'objet à enregistrer en BDD
        foreach ($entities as $entity) {
            $manager->persist($entity);
        };
        $manager->flush();
    }
}
