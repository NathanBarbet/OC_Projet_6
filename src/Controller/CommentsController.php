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

  //* Delete a comment
  public function delete($trickid, $trickname, Comments $comment, UserInterface $user): Response
  {
    $user = $this->getUser();
    $userAdmin = $user->getAdmin();
    if ($userAdmin === true)
    {
      $this->em->remove($comment);
      $this->em->flush();
      return $this->redirectToRoute('trick.show', array(
        'id' => $trickid,
        'name' => $trickname
      ));
    }
    else
    {
      $this->addFlash('message', "Vous n'avez pas l'autorisation");
      return $this->redirectToRoute('home');
    }
  }

  //* Function for display comments with "load more" button
  public function commentsAjax()
  {
    $currentPage = filter_input(INPUT_POST, 'page');
    $id = filter_input(INPUT_POST, 'id');
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

  //* Add a comment
  public function addcomment($name, $id, UserInterface $user): Response
  {
      $comment = new Comments();

      $repository = $this->getDoctrine()->getRepository(Tricks::class);
      $trick = $repository->findOneBy(
        ['id' => $id]
      );

      $content =  htmlspecialchars(filter_input(INPUT_POST,'content'));

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
