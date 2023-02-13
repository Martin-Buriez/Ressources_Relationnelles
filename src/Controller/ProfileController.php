<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class ProfileController extends AbstractController
{
    #[Route('/mon-profil', name: 'profile')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        // if($user){ 
        //     $articles = $entityManager->getRepository(Articles::class)->findUserArticles($user);
        // }else{
        //     return $this->redirectToRoute('app_login');
        // }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user'=> $user,
        ]);
    }
}
