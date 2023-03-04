<?php

namespace App\Controller;

use App\Entity\CommunicateUser;
use App\Entity\User;
use App\Entity\UserBelongGroup;
use App\Entity\UserRelationship;
use App\Form\MessageToUserType;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        
        $message = new CommunicateUser();
        $messageForm = $this->createForm(MessageToUserType::class, $message);
    
        return $this->render('user_communicates/index.html.twig', [
            'controller_name' => 'UserCommunicatesController',
            'user' => $user,
            'userProfile' => $userProfile,
            'userGroups' => $userGroups,
            'userFriends' => $userFriends,
            'messageForm' => $messageForm,
        ]);
    }

    #[Route('/mon-profil/messages/{id}', name: 'user_send')]
    public function userSendMessages(EntityManagerInterface $entityManager, Request $request, $id): Response
    {
        
        $user = $this->getUser();
        $userSender = $entityManager->getRepository(User::class)->findOneById($user);

        $userFriends = $entityManager->getRepository(UserRelationship::class)
        ->createQueryBuilder('r')
        ->where('r.userSender = :userProfile AND r.state = true OR r.userReceive = :userProfile AND r.state = true')
        ->setParameter('userProfile', $userSender)
        ->getQuery()
        ->getResult();

        $userReceive = $entityManager->getRepository(User::class)->findOneById($id);
        // $groupEntity = $entityManager->getRepository(UserBelongGroup::class)->findOneById($id);

        if ($userReceive !== null) {
            $message = new CommunicateUser();
            $messageForm = $this->createForm(MessageToUserType::class, $message);
            $messageForm->handleRequest($request);

            if($messageForm->isSubmitted() && $messageForm->isValid()){
                $message->setUserSender($userSender);
                $message->setUserReceive($userReceive);
                //Set date de création
                $dateTimeZone = new DateTimeZone('Europe/Paris');
                $date = new \DateTimeImmutable('now', $dateTimeZone);
                $message->setCreatedAt($date);
    
                $entityManager->persist($message);
                $entityManager->flush();
                $this->addFlash(
                    'message_succes',
                    'Votre message a bien été ajouté !'
                );
                return $this->redirectToRoute('user_communicates');
            }
        }

        return $this->render('user_communicates/index.html.twig', [
            'controller_name' => 'UserCommunicatesController',
            'messageForm' => $messageForm,
            'userFriends' => $userFriends,
        ]);
    }
}
