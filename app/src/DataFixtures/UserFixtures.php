<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    /** @var string PWD = test (pwd encoded) */
    private const PWD = '$argon2id$v=19$m=65536,t=4,p=1$FanJoh0SlQgQ4GpcAM/Ugw$oAVpZY+8BikxS0Cqpf4mmItDGDCAv+wa8HiEN2nWhm4';

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $object = (new User())
            ->setEmail('dev@technique')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(self::PWD)
        ;
        $manager->persist($object);

        for ($i=0; $i<20; $i++) {
            $object = (new User())
                ->setEmail($faker->email)
                ->setRoles([])
                ->setPassword(self::PWD)
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}
