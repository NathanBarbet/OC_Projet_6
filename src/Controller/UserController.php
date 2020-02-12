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


  public function adduser(AuthenticationUtils $authentificationUtils): Response
  {
      $error = $authentificationUtils->getLastAuthenticationError();


      return new Response($this->twig->render('pages/register.html.twig', [
        'error' => $error,
        '_fragment' => 'form'
      ]));
    }


    public function adduservalide(MailerInterface $mailer, AuthenticationUtils $authentificationUtils): Response
    {
        $user = new Users();
        $error = $authentificationUtils->getLastAuthenticationError();

        $emailUser = htmlspecialchars($_POST["email"]);
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $emailUsed = $repository->findBy(
          ['email' => $emailUser]
        );

          if(empty($emailUsed))
          {
            $user->setEmail($emailUser);

            $name = htmlspecialchars($_POST['name']);
            $user->setName($name);

            $firstname = htmlspecialchars($_POST['firstname']);
            $user->setFirstname($firstname);

            $plainPassword = htmlspecialchars($_POST['password']);
            $plainPasswordRepeat = htmlspecialchars($_POST['repeatpassword']);

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
                  ->from('hello@example.com')
                  ->to($emailUser)
                  ->subject('Time for Symfony Mailer!')
                  ->text('Sending emails is fun again!')
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
            $error = 'Cet email est déjà utiliser !';
          }

        return new Response($this->twig->render('pages/register.html.twig', [
          'error' => $error,
          '_fragment' => 'form'
        ]));
      }


  public function activeemail($token, $name): Response
  {

      $repository = $this->getDoctrine()->getRepository(Users::class);
      $user = $repository->findOneBy(
        ['token' => $token,
         'name' => $name]
      );

      if(empty($user))
      {
        echo "Erreur";
      }
      else {
        $user->setIsActive('1');
        $user->setToken('null');
        $this->em->flush();
        $this->addFlash('message', 'Compte validé !');
        return $this->redirectToRoute('home');
      }
    }


    public function resetpassword(AuthenticationUtils $authentificationUtils): Response
    {
        $error = $authentificationUtils->getLastAuthenticationError();

        return new Response($this->twig->render('pages/resetpassword.html.twig', [
          'error' => $error,
          '_fragment' => 'form'
        ]));
    }

    public function resetpasswordvalide(MailerInterface $mailer, AuthenticationUtils $authentificationUtils): Response
    {
        $error = $authentificationUtils->getLastAuthenticationError();

        $emailUser = htmlspecialchars($_POST["email"]);
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
                ->from('hello@example.com')
                ->to($emailUser)
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
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

        return new Response($this->twig->render('pages/register.html.twig', [
          'error' => $error,
          '_fragment' => 'form'
        ]));
      }

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
            echo "Erreur";
          }
          else {

            return new Response($this->twig->render('pages/newpassword.html.twig', [
              'error' => $error,
              'token' => $token,
              'email' => $email,
              '_fragment' => 'form'
            ]));
          }
        }

        public function setnewpassword($token, $email, AuthenticationUtils $authentificationUtils): Response
        {

            $repository = $this->getDoctrine()->getRepository(Users::class);
            $plainPassword = htmlspecialchars($_POST['password']);
            $plainPasswordRepeat = htmlspecialchars($_POST['repeatpassword']);
            $user = $repository->findOneBy(
              ['token' => $token,
               'email' => $email]
            );
            if(empty($user))
            {
              echo "Erreur";
            }
            else {
            if($plainPassword == $plainPasswordRepeat)
              {
                if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$#', $plainPassword)) {
                  $passwordHashed = $this->encoder->encodePassword($user, $plainPassword);
                  $user->setPassword($passwordHashed);
                  $user->setToken('null');

                  $this->em->flush();
                  $this->addFlash('message', 'Mot de passe modifié !');
                  return $this->redirectToRoute('home');
              	}
                  else {
                      $error = 'Mauvais mot de passe';
                      return new Response($this->twig->render('pages/newpassword.html.twig', [
                        'error' => $error,
                        'token' => $token,
                        'email' => $email,
                        '_fragment' => 'form'
                      ]));
              	}

              }
              else {
                $error = 'Mauvais mot de passe';
                return new Response($this->twig->render('pages/newpassword.html.twig', [
                  'error' => $error,
                  'token' => $token,
                  'email' => $email,
                  '_fragment' => 'form'
                ]));
              }

            return $this->redirectToRoute("home");
          }

          }

  public function login(AuthenticationUtils $authentificationUtils): Response
  {
    $error = $authentificationUtils->getLastAuthenticationError();
    $lastUsername = $authentificationUtils->getLastUsername();

      return new Response($this->twig->render('pages/login.html.twig', [
        'error' => $error,
        'last_username' => $lastUsername,
        '_fragment' => 'form'
      ]));
    }
}
