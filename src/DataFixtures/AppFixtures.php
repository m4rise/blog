<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class AppFixtures extends Fixture
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var Generator
     */
    public $faker;

    abstract protected function loadData(ObjectManager $em);

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->faker = Factory::create();
        $this->loadData($manager);
    }

    public function createMany(string $className, int $count, callable $factory): void
    {
        for ($i=0; $i<$count; $i++) {
            $entity = new $className();
            $factory($entity, $i);

            $this->manager->persist($entity);

            //référence chaque ligne pour les besoins futurs de relation entre tables
            $this->addReference($className.'_'.$i, $entity);
        }
    }
}
