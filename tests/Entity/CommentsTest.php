<?php

namespace tests\AppBundle\Entity;

use App\Entity\Comments;
use App\Entity\Tricks;
use PHPUnit\Framework\TestCase;


class CommentsTest extends TestCase
{

  public function testCommentCreate(){
    $comment = new Comments(); // Create Comments object.
    $trick = new Tricks(); // Create Tricks object.

    $comment->setContent("Test");
    $comment->setDatePublish(new \DateTime());
    $comment->setTricks($trick);

    $this->assertEquals("Test", $comment->getContent());
    $this->assertEquals($trick, $comment->getTricks());
    }


}
