<?php

namespace App\Controller;

use App\Entity\Tricks;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class TricksController extends AbstractController
{

  private $twig;

  public function __construct(Environment $twig)
  {
    $this->twig = $twig;
  }

  public function show($id): Response
  {
      $repository = $this->getDoctrine()->getRepository(Tricks::class);
      $trick = $repository->find($id);

      return new Response($this->twig->render('pages/trick.html.twig', ['trick' => $trick]));
  }

  public function addtrick(): Response
  {

      return new Response($this->twig->render('pages/trick.html.twig'));
  }

}
