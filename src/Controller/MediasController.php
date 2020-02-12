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

class MediasController extends AbstractController
{

  private $twig;

  public function __construct(Environment $twig, MediasRepository $repository, EntityManagerInterface $em)
  {
    $this->twig = $twig;
    $this->repository = $repository;
    $this->em = $em;
  }


  public function addmediasimage(Tricks $trick,Request $request): Response
  {
      $medias = new Medias;
      $form = $this->createForm(MediasImageType::class, $medias);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        // upload image medias
        $imageMedias = $form->get('imageMedias')->getData();

        if ($imageMedias) {
            $originalFilename = pathinfo($imageMedias->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
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
        return $this->redirectToRoute('trick.edit', array(
          'id' => $trick->getId(),
          'name' => $trick->getName(),
          '_fragment' => 'form'
        ));
      }

      return new Response($this->twig->render('pages/addmediasimagetrick.html.twig',  [
        'trick' => $trick,
        'medias' => $medias,
        'form' => $form->createView()
      ]));
  }

  public function addmediasvideo(Tricks $trick,Request $request): Response
  {
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
        return $this->redirectToRoute('trick.edit', array(
          'id' => $trick->getId(),
          'name' => $trick->getName(),
          '_fragment' => 'form'
        ));
      }

      return new Response($this->twig->render('pages/addmediasvideotrick.html.twig',  [
        'trick' => $trick,
        'medias' => $medias,
        'form' => $form->createView()
      ]));
  }


  public function delete($trickid, $name, Medias $medias, Request $request): Response
  {
      $this->em->remove($medias);
      $this->em->flush();
      return $this->redirectToRoute('trick.edit', array(
        'id' => $trickid,
        'name' => $name,
        '_fragment' => 'form'
      ));
  }
}
