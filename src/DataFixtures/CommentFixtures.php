<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixtures extends AppFixtures implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(250, Comment::class, function ($i) {
            $comment = new Comment();
            $comment
                ->setTitle($this->faker->sentence)
                ->setContent($this->faker->sentences($this->faker->numberBetween(2, 20), true))
                ->setAuthor($this->getReference(User::class . '_normal_' . mt_rand(1, 20)))
                ->setPost($this->getReference(Post::class . '_' . mt_rand(1, 50)))
                ->setCreatedAt($this->faker->dateTimeBetween('-1 years', '-15 days'))
                ->setUpdatedAt($this->faker->dateTimeBetween('-1 years', '-15 days'))
                ->setIsValidated($this->faker->boolean(70));

            return $comment;

        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            PostFixtures::class
        ];
    }
}
