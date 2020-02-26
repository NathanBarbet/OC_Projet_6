<?php

namespace tests\AppBundle\Entity;

use App\Entity\Users;
use PHPUnit\Framework\TestCase;


class UsersTest extends TestCase
{

  public function testUserCreate(){
    $user = new Users(); // Create Users object.
    
    $user->setName("Name");
    $user->setFirstname("Firstname");
    $user->setEmail("Email");
    $user->setPassword("PasswordTest123");


    $this->assertEquals("Name", $user->getName());
    $this->assertEquals("Firstname", $user->getFirstname());
    $this->assertEquals("Email", $user->getUsername());
    $this->assertEquals("PasswordTest123", $user->getPassword());
    }


}
