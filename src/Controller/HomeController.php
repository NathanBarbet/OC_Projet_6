<?php

namespace App\Controller;

use App\Entity\Tricks;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController extends AbstractController
{

  private $twig;

  public function __construct(Environment $twig)
  {
    $this->twig = $twig;
  }

  public function index(): Response
  {
      $repository = $this->getDoctrine()->getRepository(Tricks::class);
      $tricks = $repository->findRecentTricks();
      return new Response($this->twig->render('pages/home.html.twig', ['tricks' => $tricks]));
  }

}
