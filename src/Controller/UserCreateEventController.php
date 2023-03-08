<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use App\Entity\UserManageEvent;
use App\Form\EventType;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserCreateEventController extends AbstractController
{
    #[Route('/ajouter-evenement', name: 'create_event')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
        $userProfile = $entityManager->getRepository(User::class)->findOneById($user);

        $event = new Event();
        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);

        if($eventForm->isSubmitted() && $eventForm->isValid()){
            //On traite les thèmes
            $eventTheme = $eventForm->get('theme')->getData();
            $event->setTheme($eventTheme);

            // On traite les valeurs par défauts
            $event->setStateValidated(False);

            $eventManageEvent = new UserManageEvent();
            $eventManageEvent->setUser($userProfile);
            $eventManageEvent->setEvent($event);
            $eventManageEvent->setIsOrganizer(true);
            $eventManageEvent->setIsParticipant(true);
            $entityManager->persist($eventManageEvent);

            //Set date de création
            $dateTimeZone = new DateTimeZone('Europe/Paris');
            $date = new \DateTimeImmutable('now', $dateTimeZone);
            $event->setCreatedAt($date);

            $entityManager->persist($event);
            $entityManager->flush();
            $this->addFlash(
                'event_create_success',
                'Votre évenement a bien été ajouté !'
            );
            return $this->redirectToRoute('evenements');
        }

        return $this->render('user_create_event/index.html.twig', [
            'controller_name' => 'UserCreateEventController',
            'eventForm' => $eventForm,
            'userProfile'=> $userProfile,
        ]);
    }
}
