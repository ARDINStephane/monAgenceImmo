<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
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
        $user = new User();
        $user->setUsername('toto')
        ->setPassword($this->encoder->encodePassword($user, 'toto'));
        $user1 = new User();
        $user1->setUsername('admin')
        ->setPassword($this->encoder->encodePassword($user, 'admin'));

        $manager->persist($user);
        $manager->persist($user1);

        $manager->flush();
    }
}
