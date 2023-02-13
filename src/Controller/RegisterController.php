<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(UserPasswordHasherInterface $encorder, EntityManagerInterface $entityManager, Request $request, string $userAvatarDir): Response
    {
        $notification = null;
        $user = new User();
        $userForm = $this->createForm(RegisterType::class, $user);
        $userForm->handleRequest($request);

        if($userForm-> isSubmitted() && $userForm->isValid()) {
            $user = $userForm->getData();

            // Vérification d'un email existant
            $search_email = $entityManager->getRepository(User::class)
                ->findOneByEmail($user->getEmail());
            if(!$search_email) {
                // Encoding du mot de passe
                $passwordEncoded = $encorder->hashPassword($user, $user->getPassword());
                $user->setPassword($passwordEncoded);

                // On ajoute la date de création
                $date = new \DateTime('now');
                $user->setCreatedAt($date);

                // On upload l'avatar si il y en a un
                if($avatar = $userForm['profile_picture']->getData()){
                    $avatarFilename = bin2hex(random_bytes(6)).'.'.$avatar->guessExtension();
                    try {
                        $avatar->move($userAvatarDir, $avatarFilename);
                    } catch (FileException $e){
                        $this->addFlash('error_upload_avatar', 'Une erreur est survenue lors de l\'upload de l\'image');
                    }
                    $user->setProfilePicture($avatarFilename);
                }

                //On ajoute la validation du compte (Booléen)
                $user->setStateValidated(false);

                //On ajoute la suspension du compte (Booléen)
                $user->setStateSuspended(false);

                //On ajoute la vérification de la carte d'identité (Booléen)
                $user->setIdentityCardValidated(false);

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success_register', 'Inscription réussit, vous pouvez vous connecter');
                return $this->redirectToRoute('app_login');
            }else {
                $notification = 'L\'email saisit est déjà enregistré sur le site';
            }
        }
        return $this->render('register/index.html.twig', [
            'registerForm' => $userForm,
            'notification' => $notification
            ]);
    }
}
