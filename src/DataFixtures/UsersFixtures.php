<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
      $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
      $user = new Users();
      $user->setName('nathan');
      $user->setFirstname('barbet');
      $user->setEmail('');
      $user->setPassword($this->encoder->encodePassword($user, ''));
      $user->setDateRegister(new \DateTime);
      $user->setAvatar('lien');
      $user->setAdmin('1');
      $user->setIsActive('1');

      $manager->persist($user);
      $manager->flush();

        $manager->flush();
    }
}
