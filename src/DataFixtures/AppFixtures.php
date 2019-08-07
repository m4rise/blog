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

    /**
     * Create many objects at once:
     *
     *      $this->createMany(50, 'classname_or_custom_name' function(int $i) {
     *          $entity = new Class();
     *          $user->setField('value');
     *
     *          return $entity;
     *      });
     *
     * @param int $count
     * @param string $groupName used for references (can be the class name, or a custom name)
     * @param callable $factory
     */
    public function createMany(int $count, string $groupName, callable $factory): void
    {
        for ($i = 0; $i < $count; $i++) {

            $entity = $factory($i);

            $this->manager->persist($entity);

            $this->addReference($groupName . '_' . ($i+1), $entity);
        }
    }
}
