<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $object = (new User())
            ->setLastname('dev')
            ->setFirstname('technique')
            ->setEmail('dev@technique')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('test')
        ;
        $manager->persist($object);

        for ($i=0; $i<20; $i++) {
            $object = (new User())
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName)
                ->setEmail($faker->email)
                ->setRoles([])
                ->setPassword('test')
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}
