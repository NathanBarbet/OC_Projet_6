<?php

namespace App\Controller;

use App\Entity\Tricks;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Twig\Environment;

class HomeController extends AbstractController
{

  private $twig;

  public function __construct(Environment $twig)
  {
    $this->twig = $twig;
  }

  //* Display home page
  public function index(): Response
  {
      $repository = $this->getDoctrine()->getRepository(Tricks::class);
      $tricks = $repository->findRecentTricks(1);

      return new Response($this->twig->render('pages/home.html.twig', [
        'tricks' => $tricks
      ]));
  }

  //* Function to display tricks with "Load more" button
  public function tricksAjax()
  {
    $currentPage = filter_input(INPUT_POST, 'page');
    $repository = $this->getDoctrine()->getRepository(Tricks::class);
    $tricks = $repository->findRecentTricks($currentPage);

    $result =  $this->twig->render('pages/ajax/tricksajax.html.twig', [
        'tricks' => $tricks
    ]);

    if(!count($tricks)) {
      $result = "Plus de résultat";
    }

    return new JsonResponse(
      [
        "html" => $result,
        "page" => $currentPage + 1,
        "hideButton" => count($tricks) === 0
      ]
    );
  }

}
