<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Entity\Medias;
use App\Entity\Groupe;
use App\Entity\Users;
use App\Entity\Comments;
use App\Form\TrickType;
use App\Form\EditTrickType;
use App\Form\MediasImageType;
use App\Form\MediasVideoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Repository\MediasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class MediasController extends AbstractController
{

  private $twig;

  public function __construct(Environment $twig, MediasRepository $repository, EntityManagerInterface $em)
  {
    $this->twig = $twig;
    $this->repository = $repository;
    $this->em = $em;
  }

  //* Add a image on trick
  public function addmediasimage(Tricks $trick,Request $request): Response
  {
      $title = 'Ajouter une image';
      $medias = new Medias;
      $form = $this->createForm(MediasImageType::class, $medias);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        // upload image medias
        $imageMedias = $form->get('imageMedias')->getData();

        if ($imageMedias) {
            $originalFilename = pathinfo($imageMedias->getClientOriginalName(), PATHINFO_FILENAME);

            $newFilename = uniqid().'.'.$imageMedias->guessExtension();
            try {
                    $imageMedias->move(
                        $this->getParameter('img_media'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
            $medias->setFilename($newFilename);
        }
        // ...

        $medias->setTricks($trick);
        $medias->setType('image');
        $this->em->persist($medias);
        $this->em->flush();
        $this->addFlash('message', 'Votre image à été ajouter');
        return $this->redirectToRoute('trick.edit', array(
          'id' => $trick->getId(),
          'name' => $trick->getName(),
          '_fragment' => 'ancre'
        ));
      }

      return new Response($this->twig->render('pages/formtemplate.html.twig',  [
        'title' => $title,
        'trick' => $trick,
        'medias' => $medias,
        'form' => $form->createView()
      ]));
  }

  //* Add a video on trick
  public function addmediasvideo(Tricks $trick,Request $request): Response
  {
      $title = 'Ajouter une vidéo';
      $medias = new Medias;
      $form = $this->createForm(MediasVideoType::class, $medias);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $medias->setTricks($trick);
        $medias->setType('youtube');

        $url = $form['filename']->getData();
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);
        $medias->setFilename($matches[1]);

        $this->em->persist($medias);
        $this->em->flush();
        $this->addFlash('message', 'Votre vidéo à été ajouter');
        return $this->redirectToRoute('trick.edit', array(
          'id' => $trick->getId(),
          'name' => $trick->getName(),
          '_fragment' => 'ancre'
        ));
      }

      return new Response($this->twig->render('pages/formtemplate.html.twig',  [
        'title' => $title,
        'trick' => $trick,
        'medias' => $medias,
        'form' => $form->createView()
      ]));
  }

  //* Delete a media on trick
  public function delete($trickid, $name, Medias $medias, UserInterface $user): Response
  {
    $user = $this->getUser();
    $userActive = $user->getIsActive();
    $userValide = $user->getIsValide();
    if ($userActive === true & $userValide === true)
    {
      $this->em->remove($medias);
      $this->em->flush();
      $this->addFlash('message', 'Le média à été supprimer');
      return $this->redirectToRoute('trick.edit', array(
        'id' => $trickid,
        'name' => $name,
        '_fragment' => 'ancre'
      ));
    }
    else
    {
      $this->addFlash('message', "Vous n'avez pas l'autorisation");
      return $this->redirectToRoute('home');
    }
  }
}
