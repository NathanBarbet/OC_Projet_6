<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Entity\Medias;
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
      dump($trick);

      $repository = $this->getDoctrine()->getRepository(Medias::class);
      $medias = $repository->findMediasTrick($id);
      return new Response($this->twig->render('pages/trick.html.twig', ['trick' => $trick, 'medias' => $medias]));
  }

  public function addtrick(): Response
  {

      return new Response($this->twig->render('pages/trick.html.twig'));
  }

}
