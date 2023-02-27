<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserBelongGroup;
use App\Entity\UserRelationship;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserCommunicatesController extends AbstractController
{
    #[Route('/mon-profil/messages', name: 'user_communicates')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $userProfile = $entityManager->getRepository(User::class)->findOneById($user);
        $userGroups = $entityManager->getRepository(UserBelongGroup::class)->findBy(['user' => $userProfile]);

        $userFriends = $entityManager->getRepository(UserRelationship::class)
            ->createQueryBuilder('r')
            ->where('r.userSender = :userProfile AND r.state = true OR r.userReceive = :userProfile AND r.state = true')
            ->setParameter('userProfile', $userProfile)
            ->getQuery()
            ->getResult();
    
        return $this->render('user_communicates/index.html.twig', [
            'controller_name' => 'UserCommunicatesController',
            'user' => $user,
            'userProfile' => $userProfile,
            'userGroups' => $userGroups,
            'userFriends' => $userFriends
        ]);
    }
}
