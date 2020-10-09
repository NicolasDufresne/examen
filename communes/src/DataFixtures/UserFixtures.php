<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'password'
        ));

        $user->setEmail('email@gmail.com')
            ->setRoles(["ROLE_USER"]);

        $manager->persist($user);
        $manager->flush();



        $admin = new User();

        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'password'
        ));

        $admin->setEmail('admin@gmail.com')
            ->setRoles(["ROLE_SUPER_ADMIN"]);

        $manager->persist($admin);
        $manager->flush();
    }
}
