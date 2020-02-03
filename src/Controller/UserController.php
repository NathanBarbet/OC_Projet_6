<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class UserController
{

  private $twig;

  public function __construct(Environment $twig)
  {
    $this->twig = $twig;
  }

  public function login(): Response
  {
      return new Response($this->twig->render('pages/login.html.twig'));
  }
  
}
