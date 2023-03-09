<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminEventController extends AbstractController
{
    #[Route('/admin/event', name: 'admin_event')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $events = $entityManager->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->where('e.stateValidated = false') 
            ->getQuery()
            ->getResult();

        return $this->render('Admin/event/index.html.twig', [
            'controller_name' => 'AdminEventController',
            'events' => $events,
        ]);
    }

    #[Route('/admin/event/delete/{idEvent}', name: 'admin_delete_event')]
    public function adminDeleteEvent(EntityManagerInterface $entityManager, $idEvent): Response
    {
        $event = $entityManager->getRepository(Event::class)->find($idEvent);
        if (!$event) {
            $this->addFlash('error', 'L\'événement n\'existe pas');
        } else {
            // Supprimer l'entité
            $entityManager->remove($event);
            $entityManager->flush();
            $this->addFlash('success', 'L\'événement à été supprimée avec succès.');
        }
        return $this->redirectToRoute('admin_event');
    }

    #[Route('/admin/event/validate/{idEvent}', name: 'admin_validate_event')]
    public function adminValidateEvent(EntityManagerInterface $entityManager, $idEvent): Response
    {
        $event = $entityManager->getRepository(Event::class)->find($idEvent);
        if (!$event) {
            $this->addFlash('error', 'L\'événement n\'existe pas');
        } else {
            $event->setStateValidated(true);
            $entityManager->persist($event);
            $entityManager->flush();
            $this->addFlash('success', 'L\'événement à été vérifié.');
        }
        return $this->redirectToRoute('admin_event');
    }
}
