<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserFriendController extends AbstractController
{
    #[Route('/mon-profil/friends', name: 'user_friend')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $userEntity = $entityManager->getRepository(User::class)->findAll();

        return $this->render('user_friend/index.html.twig', [
            'controller_name' => 'UserFriendController',
            'user' => $userEntity,
        ]);
    }
}
