<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
       $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('Paul');
        $password = $this->encoder->encodePassword($user, '1234');
        $user->setPassword($password);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('Quentin');
        $password = $this->encoder->encodePassword($user, 'azerty');
        $user->setPassword($password);
        $manager->persist($user);

        $manager->flush();
        // $product = new Product();
        // $manager->persist($product);

    }
}
