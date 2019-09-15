<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;

class PostFixtures extends AppFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, Post::class, function ($count) {

            $post = new Post();
            $post
                ->setTitle($this->faker->sentence())
                ->setLede($this->faker->sentences(4, true))
                ->setContent($this->faker->paragraphs($nb = 25, $asText = true))
                ->setAuthor($this->getReference(User::class . '_admin_' . mt_rand(1, 3)))
                ->setCreatedAt($this->faker->dateTimeBetween('-2 years', '-15 days'))
                ->setUpdatedAt($this->faker->dateTimeBetween('-6 months', 'now'))
                ->setIsPublished($this->faker->boolean(90))
                ->setIsVisible($this->faker->boolean(90));

            return $post;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
