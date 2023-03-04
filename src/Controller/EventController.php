<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Entity\UserManageEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/evenements', name: 'evenements')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $events = $entityManager->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->where('e.stateValidated = true')
            ->getQuery()
            ->getResult();

        $user = $this->getUser();
        $userProfile = $entityManager->getRepository(User::class)->findOneById($user);

        $userManageEvents = $entityManager->getRepository(UserManageEvent::class)
            ->createQueryBuilder('m')
            ->where('m.User = :userProfile AND (m.IsParticipant = true OR m.IsOrganizer = true)') 
            ->setParameter('userProfile', $userProfile)
            ->getQuery()
            ->getResult();

        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
            'events' => $events,
            'userManageEvents' => $userManageEvents
        ]);
    }

    #[Route('/evenements/ajout/{idEvent}', name: 'user_participe_event')]
    public function addParticipantInEvent(EntityManagerInterface $entityManager, $idEvent): Response
    {        
        $user = $this->getUser();
        $userProfile = $entityManager->getRepository(User::class)->findOneById($user);

        $event = $entityManager->getRepository(Event::class)->findOneById($idEvent);

        $userManageEventRepository = $entityManager->getRepository(UserManageEvent::class);
        $userManageEvent = $userManageEventRepository->findOneBy(['User' => $userProfile, 'event' => $event]);
        
        if ($userManageEvent !== null) {
            // The user is managing the event
            $this->addFlash('error', 'Vous êtes déja inscript à cet événement');
        } else {
            // The user is not managing the event
            $eventManageEvent = new UserManageEvent();
            $eventManageEvent->setUser($userProfile);
            $eventManageEvent->setEvent($event);
            $eventManageEvent->setIsOrganizer(false);
            $eventManageEvent->setIsParticipant(true);
            $entityManager->persist($eventManageEvent);
            $this->addFlash('succes', 'Bravo Vous êtes inscript à cet événement');
        }
        return $this->redirectToRoute('evenements');
    }
}
