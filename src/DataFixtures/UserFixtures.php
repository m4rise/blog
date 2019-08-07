<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends AppFixtures
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(3, User::class.'_admin', function ($i) {
            $user = new User();
            $user
                ->setEmail(sprintf('admin%d@email.com', $i))
                ->setNickname($this->faker->userName)
                ->setPassword($this->encoder->encodePassword($user, 'admin'))
                ->setRoles(['ROLE_ADMIN']);

            return $user;
        });

        $this->createMany(20, User::class.'_normal', function ($i) {
            $user = new User();
            $user
                ->setEmail(sprintf('user%d@email.com', $i))
                ->setNickname($this->faker->userName)
                ->setPassword($this->encoder->encodePassword($user, 'password'));

            return $user;
        });

        $manager->flush();
    }
}
