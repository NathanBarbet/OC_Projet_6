<?php

namespace tests\AppBundle\Entity;

use App\Entity\Medias;
use App\Entity\Tricks;
use PHPUnit\Framework\TestCase;


class MediasTest extends TestCase
{

  public function testImageCreate()
  {
    $media = new Medias(); // Create Medias object.
    $trick = new Tricks(); // Create Tricks object.

    $media->setFilename("Test");
    $media->setDatePublish(new \DateTime());
    $media->setTricks($trick);

    $this->assertEquals("Test", $media->getFilename());
    $this->assertEquals($trick, $media->getTricks());
  }

  public function testVideoCreate()
  {
    $media = new Medias(); // Create Medias object.
    $trick = new Tricks(); // Create Tricks object.

    $url = 'https://www.youtube.com/watch?v=Abcdef12345';
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);
    $media->setFilename($matches[1]);

    $media->setDatePublish(new \DateTime());
    $media->setTricks($trick);

    $this->assertEquals("Abcdef12345", $media->getFilename());
    $this->assertEquals($trick, $media->getTricks());
  }
}
