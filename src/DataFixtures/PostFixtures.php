<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class PostFixtures extends AppFixtures
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Post::class, 50, function (Post $post, $count) {
            $post
                ->setTitle($this->faker->sentence())
                ->setLede($this->faker->sentences(4, true))
                ->setContent($this->faker->paragraphs($nb = 50, $asText = true))
                ->setAuthor('Damien DUVAL')
                ->setCreatedAt($this->faker->dateTimeBetween('-2 years', '-15 days'))
                ->setUpdatedAt($this->faker->dateTimeBetween('-6 months', 'now'))
                ->setIsPublished($this->faker->boolean(90))
                ->setIsVisible($this->faker->boolean(90));
        });

        $manager->flush();
    }
}
