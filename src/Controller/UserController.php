<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use App\Entity\Users;
use App\Form\UserLoginType;
use App\Form\UserRegisterType;
use App\Form\EditProfilType;
use Doctrine\ORM\EntityManagerInterface;


class UserController extends AbstractController
{

  private $twig;
  private $encoder;

  public function __construct(UserPasswordEncoderInterface $encoder, Environment $twig, EntityManagerInterface $em)
  {
    $this->twig = $twig;
    $this->encoder = $encoder;
    $this->em = $em;
  }

  //* Display register page
  public function adduser(AuthenticationUtils $authentificationUtils): Response
  {
      $error = $authentificationUtils->getLastAuthenticationError();


      return new Response($this->twig->render('pages/users/register.html.twig', [
        'error' => $error,
        '_fragment' => 'ancre'
      ]));
    }

    //* Valide register of user
    public function adduservalide(MailerInterface $mailer, AuthenticationUtils $authentificationUtils): Response
    {
        $user = new Users();
        $error = $authentificationUtils->getLastAuthenticationError();

        $emailUser = htmlspecialchars(filter_input(INPUT_POST, 'email'));
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $emailUsed = $repository->findBy(
          ['email' => $emailUser]
        );

          if(empty($emailUsed))
          {
            if(filter_var($emailUser, FILTER_VALIDATE_EMAIL))
            {
              $user->setEmail($emailUser);

              $name = htmlspecialchars(filter_input(INPUT_POST, 'name'));
              $user->setName($name);

              $firstname = htmlspecialchars(filter_input(INPUT_POST, 'firstname'));
              $user->setFirstname($firstname);

              $plainPassword = htmlspecialchars(filter_input(INPUT_POST, 'password'));
              $plainPasswordRepeat = htmlspecialchars(filter_input(INPUT_POST, 'repeatpassword'));

              if($plainPassword == $plainPasswordRepeat)
              {
                if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$#', $plainPassword)) {
                  $passwordHashed = $this->encoder->encodePassword($user, $plainPassword);
                  $user->setPassword($passwordHashed);

                  $bytes = uniqid();
                  $token = bin2hex($bytes);
                  $user->setToken($token);

                  $user->setAdmin('0');
                  $user->setIsActive('0');
                  $user->setIsValide('0');

                  $this->em->persist($user);
                  $this->em->flush();


                  $email = (new Email())
                    ->from('contact@snowtricks.fr')
                    ->to($emailUser)
                    ->subject('Email de validation')
                    ->text('Cliquez sur le lien pour valider votre email !')
                    ->html("<p>http://localhost/P6/public/activeemail-$token-$name</p>");

                  /** @var Symfony\Component\Mailer\SentMessage $sentEmail */
                  $sentEmail = $mailer->send($email);
                  // $messageId = $sentEmail->getMessageId();
                  $this->addFlash('message', 'Vous avez reçu un lien de validation par email');
                  return $this->redirectToRoute('home');
              	}

                  else {
                      $error = 'Mauvais mot de passe';
              	}

              }
              else {
                $error = 'Mauvais mot de passe';
              }

            }
            else {
              $error = 'Email invalide';
            }
            }


          else {
            $error = 'Cet email est déjà utiliser !';
          }

        return new Response($this->twig->render('pages/users/register.html.twig', [
          'error' => $error,
          '_fragment' => 'ancre'
        ]));
      }

  //* Valide email of user
  public function activeemail($token, $name): Response
  {

      $repository = $this->getDoctrine()->getRepository(Users::class);
      $user = $repository->findOneBy(
        ['token' => $token,
         'name' => $name]
      );

      if(empty($user))
      {
        $this->addFlash('message', 'Erreur');
      }
      else {
        $user->setIsActive('1');
        $user->setToken(NULL);
        $this->em->flush();
        $this->addFlash('message', 'Compte validé !');
        return $this->redirectToRoute('home');
      }
    }

    //* Display forgot password page
    public function resetpassword(AuthenticationUtils $authentificationUtils): Response
    {
        $error = $authentificationUtils->getLastAuthenticationError();

        return new Response($this->twig->render('pages/users/resetpassword.html.twig', [
          'error' => $error,
          '_fragment' => 'ancre'
        ]));
    }

    //* Valide a forgot password form
    public function resetpasswordvalide(MailerInterface $mailer, AuthenticationUtils $authentificationUtils): Response
    {
        $error = $authentificationUtils->getLastAuthenticationError();

        $emailUser = htmlspecialchars(filter_input(INPUT_POST, 'email'));
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $emailUsed = $repository->findOneBy(
          ['email' => $emailUser]
        );

          if(!empty($emailUsed))
          {
              $bytes = uniqid();
              $token = bin2hex($bytes);
              $emailUsed->setToken($token);
              $this->em->flush();

              $email = (new Email())
                ->from('contact@snowtricks.fr')
                ->to($emailUser)
                ->subject('Mot de passe oublié')
                ->text('Cliquez sur le lien pour modifier votre mot de passe')
                ->html("<p>http://localhost/P6/public/newpassword-$token-$emailUser</p>");

              /** @var Symfony\Component\Mailer\SentMessage $sentEmail */
              $sentEmail = $mailer->send($email);
              // $messageId = $sentEmail->getMessageId();
              $this->addFlash('message', 'Vous avez reçu un email de réinitialisation.');
              return $this->redirectToRoute('home');

          }
          else {
            $error = 'Cet email ne correspond a aucun compte';
          }

        return new Response($this->twig->render('pages/users/resetpassword.html.twig', [
          'error' => $error,
          '_fragment' => 'ancre'
        ]));
      }

      //* Display page reset password with verification of token
      public function newpassword($token, $email, AuthenticationUtils $authentificationUtils): Response
      {
          $error = $authentificationUtils->getLastAuthenticationError();

          $repository = $this->getDoctrine()->getRepository(Users::class);
          $user = $repository->findBy(
            ['token' => $token,
             'email' => $email]
          );

          if(empty($user))
          {
            $this->addFlash('message', 'Erreur');
          }
          else {

            return new Response($this->twig->render('pages/users/newpassword.html.twig', [
              'error' => $error,
              'token' => $token,
              'email' => $email,
              '_fragment' => 'ancre'
            ]));
          }
        }

        //* Set new password after forgot password action if all is valid
        public function setnewpassword($token, $email): Response
        {

            $repository = $this->getDoctrine()->getRepository(Users::class);
            $plainPassword = htmlspecialchars(filter_input(INPUT_POST, 'password'));
            $plainPasswordRepeat = htmlspecialchars(filter_input(INPUT_POST, 'repeatpassword'));
            $user = $repository->findOneBy(
              ['token' => $token,
               'email' => $email]
            );
            if(empty($user))
            {
              $this->addFlash('message', 'Erreur');
            }
            else {
            if($plainPassword == $plainPasswordRepeat)
              {
                if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$#', $plainPassword)) {
                  $passwordHashed = $this->encoder->encodePassword($user, $plainPassword);
                  $user->setPassword($passwordHashed);
                  $user->setToken(NULL);

                  $this->em->flush();
                  $this->addFlash('message', 'Mot de passe modifié !');
                  return $this->redirectToRoute('home');
              	}
                  else {
                      $error = 'Mauvais mot de passe';
                      return new Response($this->twig->render('pages/users/newpassword.html.twig', [
                        'error' => $error,
                        'token' => $token,
                        'email' => $email,
                        '_fragment' => 'ancre'
                      ]));
              	}

              }
              else {
                $error = 'Mauvais mot de passe';
                return new Response($this->twig->render('pages/users/newpassword.html.twig', [
                  'error' => $error,
                  'token' => $token,
                  'email' => $email,
                  '_fragment' => 'ancre'
                ]));
              }

            return $this->redirectToRoute("home");
          }

          }

  //* Login function
  public function login(AuthenticationUtils $authentificationUtils): Response
  {
    $error = $authentificationUtils->getLastAuthenticationError();
    $lastUsername = $authentificationUtils->getLastUsername();

      return new Response($this->twig->render('pages/users/login.html.twig', [
        'error' => $error,
        'last_username' => $lastUsername,
        '_fragment' => 'ancre'
      ]));
    }

    //* Display profil page
    public function profil(): Response
    {
        return new Response($this->twig->render('pages/users/profil.html.twig', [

        ]));
    }

    //* Page edit profil
    public function editprofil(Request $request, UserInterface $user): Response
    {
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          // upload Avatar
          $avatar = $form->get('avatar')->getData();

          if ($avatar) {
              $originalFilename = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);

              $newFilename = uniqid().'.'.$avatar->guessExtension();
              try {
                      $avatar->move(
                          $this->getParameter('avatar'),
                          $newFilename
                      );
                  } catch (FileException $e) {
                  }
              $user->setFilename($newFilename);
          }
          // ...

          $this->em->flush();
          $this->addFlash('message', 'Votre profil à été mis à jour');
          return $this->redirectToRoute('profil');
        }


        return new Response($this->twig->render('pages/users/editprofil.html.twig', [
          'form' => $form->createView()
        ]));
    }

    //* Display edit password page in profil user
    public function editprofilpassword(AuthenticationUtils $authentificationUtils): Response
    {
      $error = $authentificationUtils->getLastAuthenticationError();

        return new Response($this->twig->render('pages/users/editprofilpassword.html.twig', [
          'error' => $error
        ]));
    }

    //* Set new password
    public function editprofilpasswordvalide(UserInterface $user, AuthenticationUtils $authentificationUtils): Response
    {
      $error = $authentificationUtils->getLastAuthenticationError();
      $plainPassword = htmlspecialchars(filter_input(INPUT_POST, 'password'));
      $plainPasswordRepeat = htmlspecialchars(filter_input(INPUT_POST, 'repeatpassword'));

      if($plainPassword == $plainPasswordRepeat)
        {
          if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$#', $plainPassword)) {
            $passwordHashed = $this->encoder->encodePassword($user, $plainPassword);
            $user->setPassword($passwordHashed);

            $this->em->flush();
            $this->addFlash('message', 'Mot de passe modifié !');
            return $this->redirectToRoute('profil');
          }
            else {
                $error = 'Mauvais mot de passe';
                return new Response($this->twig->render('pages/users/editprofilpassword.html.twig', [
                  'error' => $error,
                  '_fragment' => 'ancre'
                ]));
          }

        }
        else {
          $error = 'Mauvais mot de passe';
          return new Response($this->twig->render('pages/users/editprofilpassword.html.twig', [
            'error' => $error,
            '_fragment' => 'ancre'
          ]));
        }

      return $this->redirectToRoute("profil");



        return new Response($this->twig->render('pages/users/editprofilpassword.html.twig', [
        ]));

    }

    //* Admin page
    public function admin(UserInterface $user): Response
    {
      $user = $this->getUser();
      $userAdmin = $user->getAdmin();
      if ($userAdmin === true)
      {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findUsers();

        return new Response($this->twig->render('pages/admin/admin.html.twig', [
          'users' => $users,
        ]));
      }
      else
      {
        $this->addFlash('message', "Vous n'avez pas l'autorisation");
        return $this->redirectToRoute('home');
      }
    }

    //* Valide a user
    public function valideuser($id, UserInterface $user): Response
    {
      $user = $this->getUser();
      $userAdmin = $user->getAdmin();
      if ($userAdmin === true)
      {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $user = $repository->findOneBy(
          ['id' => $id]
        );

        $user->setIsValide('1');
        $this->em->flush();
        return $this->redirectToRoute('admin', array(
          '_fragment' => 'ancre'
        ));
      }
      else
      {
        $this->addFlash('message', "Vous n'avez pas l'autorisation");
        return $this->redirectToRoute('home');
      }

      return new Response($this->twig->render('pages/admin/admin.html.twig', [
        'users' => $users
      ]));
    }

    //* Unvalide a user
    public function unvalideuser($id, UserInterface $user): Response
    {
      $user = $this->getUser();
      $userAdmin = $user->getAdmin();
      if ($userAdmin === true)
      {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $user = $repository->findOneBy(
          ['id' => $id]
        );

        $user->setIsValide('0');
        $this->em->flush();
        return $this->redirectToRoute('viewvalideuser', array(
          '_fragment' => 'ancre'
        ));
      }
      else
      {
        $this->addFlash('message', "Vous n'avez pas l'autorisation");
        return $this->redirectToRoute('home');
      }

      return new Response($this->twig->render('pages/admin/admin.html.twig'));
    }

    //* View Valide user
    public function viewvalideuser(): Response
    {
      $user = $this->getUser();
      $userAdmin = $user->getAdmin();
      if ($userAdmin === true)
      {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findUsers();

        return new Response($this->twig->render('pages/admin/valideuser.html.twig', [
          'users' => $users,
        ]));
      }
      else
      {
        $this->addFlash('message', "Vous n'avez pas l'autorisation");
        return $this->redirectToRoute('home');
      }
    }
}
