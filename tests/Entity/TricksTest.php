<?php

namespace tests\AppBundle\Entity;

use App\Entity\Tricks;
use App\Entity\Users;
use PHPUnit\Framework\TestCase;


class TricksTest extends TestCase
{

  public function testTrickCreate(){

    $trick = new Tricks();
    $user = new Users();


    $trick->setUser($user);
    $trick->setDescription('Test');
    $trick->setName('Name');

    $this->assertEquals($user, $trick->getUser());
    $this->assertEquals('Test', $trick->getDescription());
    $this->assertEquals('Name', $trick->getName());
    }


}
