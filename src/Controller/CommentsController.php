<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Entity\Users;
use App\Entity\Comments;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentsController extends AbstractController
{

  private $twig;

  public function __construct(Environment $twig, CommentsRepository $repository, EntityManagerInterface $em)
  {
    $this->twig = $twig;
    $this->repository = $repository;
    $this->em = $em;
  }

  public function delete($trickid, $trickname, Comments $comment): Response
  {
      $this->em->remove($comment);
      $this->em->flush();
      return $this->redirectToRoute('trick.show', array(
        'id' => $trickid,
        'name' => $trickname
      ));
  }

  public function commentsAjax(Request $request)
  {
    $currentPage = $_POST['page'];
    $id = $_POST['id'];
    $repository = $this->getDoctrine()->getRepository(Comments::class);
    $comments = $repository->findRecentComments($id, $currentPage);

    $result =  $this->twig->render('pages/ajax/commentsajax.html.twig', [
        'comments' => $comments
    ]);

    if(!count($comments)) {
      $result = "Pas de commentaires";
    }

    return new JsonResponse(
      [
        "html" => $result,
        "page" => $currentPage + 1,
        "hideButton" => count($comments) === 0
      ]
    );
  }

  public function addcomment($name, $id, Request $request, UserInterface $user): Response
  {
      $comment = new Comments();

      $repository = $this->getDoctrine()->getRepository(Tricks::class);
      $trick = $repository->findOneBy(
        ['id' => $id]
      );

      $content = htmlspecialchars($_POST['content']);

      if (isset($content) && !empty($content))
      {
        $comment->setContent($content);
        $comment->setTricks($trick);
        $comment->setUser($user);

        $this->em->persist($comment);
        $this->em->flush();

        $this->addFlash('message', 'Votre commentaire à été poster');
        return $this->redirectToRoute('trick.show', array(
          'id' => $id,
          'name' => $name
        ));
      }
      else
      {
        $this->addFlash('message', 'Erreur: Commentaire vide');
        return $this->redirectToRoute('trick.show', array(
          'id' => $id,
          'name' => $name
        ));
      }
  }
}
