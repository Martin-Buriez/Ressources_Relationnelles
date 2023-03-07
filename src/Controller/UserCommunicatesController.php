<?php

namespace App\Controller;

use App\Entity\CommunicateUser;
use App\Entity\Group;
use App\Entity\User;
use App\Entity\UserBelongGroup;
use App\Entity\UserCommunicateGroup;
use App\Entity\UserRelationship;
use App\Form\MessageToGroupType;
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

        $userConversation = [];
        $groupConversation = [];

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
            'userConversation' => $userConversation,
            'groupConversation' => $groupConversation
        ]);
    }

    #[Route('/mon-profil/messages/{id}', name: 'user_send_message')]
    public function userSendMessages(EntityManagerInterface $entityManager, Request $request, $id): Response
    {
        $user = $this->getUser();
        $userProfile = $entityManager->getRepository(User::class)->findOneById($user);
        $userGroups = $entityManager->getRepository(UserBelongGroup::class)->findBy(['user' => $userProfile]);

        $userSender = $entityManager->getRepository(User::class)->findOneById($user);
        $userReceive = $entityManager->getRepository(User::class)->findOneById($id);

        $groupConversation = [];

        $userFriends = $entityManager->getRepository(UserRelationship::class)
            ->createQueryBuilder('r')
            ->where('r.userSender = :userProfile AND r.state = true OR r.userReceive = :userProfile AND r.state = true')
            ->setParameter('userProfile', $userSender)
            ->getQuery()
            ->getResult();

        $userConversation = $entityManager->getRepository(CommunicateUser::class)
            ->createQueryBuilder('r')
            ->where('(r.userSender = :userSender OR r.userReceive = :userSender) AND (r.userSender = :userReceive OR r.userReceive = :userReceive)')
            ->setParameter('userSender', $userSender)
            ->setParameter('userReceive', $userReceive)
            ->orderBy('r.createdAt', 'ASC')
            ->getQuery()
            ->getResult();

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
                return $this->redirect($request->getUri());
            }
        }

        return $this->render('user_communicates/index.html.twig', [
            'controller_name' => 'UserCommunicatesController',
            'messageForm' => $messageForm,
            'userFriends' => $userFriends,
            'userConversation' => $userConversation,
            'userGroups' => $userGroups, 
            'groupConversation' => $groupConversation,
        ]);
    }

    #[Route('/mon-profil/messages/group/{idGroup}', name: 'user_send_message_group')]
    public function userSendMessagesInGroup(EntityManagerInterface $entityManager, Request $request, $idGroup): Response
    {   
        //Get profile user
        $user = $this->getUser();
        $userProfile = $entityManager->getRepository(User::class)->findOneById($user);
        //Get group link with user profile
        $userGroups = $entityManager->getRepository(UserBelongGroup::class)->findBy(['user' => $userProfile]);
        
        //Init empty user conversation
        $userConversation = [];
        
        //Get friends of user profile
        $userFriends = $entityManager->getRepository(UserRelationship::class)
            ->createQueryBuilder('r')
            ->where('r.userSender = :userProfile AND r.state = true OR r.userReceive = :userProfile AND r.state = true')
            ->setParameter('userProfile', $userProfile)
            ->getQuery()
            ->getResult();
        
        //Get group with id in route
        $groupe = $entityManager->getRepository(Group::class)->find($idGroup);

        //Get user in group
        $userBelongGroup = $entityManager->getRepository(UserBelongGroup::class)->findById($groupe);
        
        $groupConversation = $entityManager->getRepository(UserCommunicateGroup::class)
            ->createQueryBuilder('c')
            ->where('c.groupe = :idGroup')
            ->setParameter('idGroup', $idGroup)
            ->orderBy('c.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
            
        //Init form send message
        if ($groupe !== null) {
            $messageGroup = new UserCommunicateGroup();
            $messageGroupFrom = $this->createForm(MessageToGroupType::class, $messageGroup);
            $messageGroupFrom->handleRequest($request);

            if($messageGroupFrom->isSubmitted() && $messageGroupFrom->isValid()){
                //Set date de création
                $dateTimeZone = new DateTimeZone('Europe/Paris');
                $date = new \DateTimeImmutable('now', $dateTimeZone);
                $messageGroup->setCreatedAt($date);

                $messageGroup->setGroupe($groupe);
                $messageGroup->setUserSendMessage($userProfile);

                $entityManager->persist($messageGroup);
                $entityManager->flush();
                $this->addFlash(
                    'message_succes',
                    'Votre message a bien été ajouté !'
                );
                return $this->redirect($request->getUri());
            }
        }
        return $this->render('user_communicates/index.html.twig', [
            'controller_name' => 'UserCommunicatesController',
            'userBelongGroup' => $userBelongGroup,
            'user' => $user,
            'userProfile' => $userProfile,
            'userGroups' => $userGroups,
            'userFriends' => $userFriends,
            'groupConversation' => $groupConversation,
            'messageForm' => $messageGroupFrom,
            'userConversation' => $userConversation,
        ]);
    }
}