<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\IdentityCardType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileUserController extends AbstractController
{
    #[Route('/profil-de/{username}', name: 'profile_view')]
    public function index(EntityManagerInterface $entityManager, $username): Response
    {
        $userProfile = $entityManager->getRepository(User::class)->findOneByUsername($username);

        return $this->render('profile_user/index.html.twig', [
            'controller_name' => 'ProfileUserController',
            'userProfile' => $userProfile,
        ]);
    }
}
