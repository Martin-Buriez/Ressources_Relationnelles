<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserRelationship;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class UserFriendListController extends AbstractController
{

    #[Route('/mon-profil/mes-amis', name: 'user_friend_list')]
    public function index(EntityManagerInterface $entityManager, Request $request, Security $security ): Response
    {
        $user = $this->getUser();
        $userProfile = $entityManager->getRepository(User::class)->findOneById($user);
        $userFriend = $entityManager->getRepository(UserRelationship::class)
            ->createQueryBuilder('r')
            ->where('r.state = true AND (r.userSender = :userProfile OR r.userReceive = :userProfile)') 
            ->setParameter('userProfile', $userProfile)
            ->getQuery()
            ->getResult();

        return $this->render('user_friend_list/index.html.twig', [
            'controller_name' => 'UserFriendController',
            'userFriend'=> $userFriend,
        ]);
    }
}
