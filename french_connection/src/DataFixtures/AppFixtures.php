<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $loader = new NativeLoader();

        $entities = $loader->loadFile(__DIR__.'/fixtures.yml')->getObjects();

        foreach ($entities as $entity) {
            $manager->persist($entity);
        };

        $manager->flush();
    }
}
