<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserFriendController extends AbstractController
{

    #[Route('/mon-profil/friends', name: 'user_friend')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        // $userEntity = $entityManager->getRepository(User::class)->findAll();
        $userEntity = $entityManager->getRepository(User::class)->findAll();
        $userFilter = [];
        
        $search = $request->query->get('search');
        if ($search) {
            $userFilter = $entityManager->getRepository(User::class)->findBySearch($search);
        }
    
        return $this->render('user_friend/index.html.twig', [
            'controller_name' => 'UserFriendController',
            'userFilter' => $userFilter,
            'userEntity' => $userEntity,
        ]);
    }
}
