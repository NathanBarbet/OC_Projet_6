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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TricksController extends AbstractController
{

  private $twig;

  public function __construct(Environment $twig, TricksRepository $repository, EntityManagerInterface $em)
  {
    $this->twig = $twig;
    $this->repository = $repository;
    $this->em = $em;
  }

  public function show($id): Response
  {
      $repository = $this->getDoctrine()->getRepository(Tricks::class);
      $trick = $repository->find($id);

      $repository = $this->getDoctrine()->getRepository(Medias::class);
      $medias = $repository->findMediasTrick($id);

      return new Response($this->twig->render('pages/trick.html.twig', [
        'trick' => $trick,
        'medias' => $medias
      ]));
  }

  public function addtrick(Request $request, UserInterface $user): Response
  {
      $trick = new Tricks();
      $form = $this->createForm(TrickType::class, $trick);
      $form->handleRequest($request);


      if ($form->isSubmitted() && $form->isValid()) {

        $trick->setUser($user);
        // upload image home
        $imageHome = $form->get('imageHome')->getData();

        if ($imageHome) {
            $originalFilename = pathinfo($imageHome->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = uniqid().'.'.$imageHome->guessExtension();
            try {
                    $imageHome->move(
                        $this->getParameter('img_home'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
            $trick->setFilename($newFilename);
        }
        // ...
        // upload image background
        $imageBackground = $form->get('imageBackground')->getData();

        if ($imageBackground) {
            $originalFilename = pathinfo($imageBackground->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = uniqid().'.'.$imageBackground->guessExtension();
            try {
                    $imageBackground->move(
                        $this->getParameter('img_background'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
            $trick->setImgBackground($newFilename);
        }
        // ...
        $name = $form['name']->getData();
        $repository = $this->getDoctrine()->getRepository(Tricks::class);
        $tricks = $repository->findBy(
          ['name' => $name]
        );
          if(empty($tricks))
          {
            $this->em->persist($trick);
            $this->em->flush();
            return $this->redirectToRoute('home');
          }
          else {
            echo 'Ce tricks existe déjà !';
          }
      }

      return new Response($this->twig->render('pages/addtrick.html.twig', [
        'trick' => $trick,
        'form' => $form->createView()
      ]));
  }

  public function edit(Tricks $trick, Request $request, UserInterface $user): Response
  {
      $form = $this->createForm(EditTrickType::class, $trick);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

        $trick->setUserModify($user);
        // upload image home
        $imageHome = $form->get('imageHome')->getData();

        if ($imageHome) {
            $originalFilename = pathinfo($imageHome->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = uniqid().'.'.$imageHome->guessExtension();
            try {
                    $imageHome->move(
                        $this->getParameter('img_home'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
            $trick->setFilename($newFilename);
        }
        // ...
        // upload image background
        $imageBackground = $form->get('imageBackground')->getData();

        if ($imageBackground) {
            $originalFilename = pathinfo($imageBackground->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = uniqid().'.'.$imageBackground->guessExtension();
            try {
                    $imageBackground->move(
                        $this->getParameter('img_background'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
            $trick->setImgBackground($newFilename);
        }
        // ...
        $id = $trick->getId();
        $name = $form['name']->getData();
        $repository = $this->getDoctrine()->getRepository(Tricks::class);
        $tricks = $repository->verifyName($id, $name);
          if(empty($tricks))
          {
            $this->em->flush();
            return $this->redirectToRoute('trick.show', array(
              'name' => $trick->getName(),
              'id' => $trick->getId()
            ));
          }
          else {
            echo 'Ce tricks existe déjà !';
          }
      }
      
      $repository = $this->getDoctrine()->getRepository(Medias::class);
      $medias = $repository->findMediasTrick($trick->getId());

      return new Response($this->twig->render('pages/edittrick.html.twig', [
        'medias' => $medias,
        'trick' => $trick,
        'form' => $form->createView()
      ]));
  }

  public function delete(Tricks $trick): Response
  {
      $this->em->remove($trick);
      $this->em->flush();
      return $this->redirectToRoute('home', array(
        '_fragment' => 'projects'
      ));
  }
}
