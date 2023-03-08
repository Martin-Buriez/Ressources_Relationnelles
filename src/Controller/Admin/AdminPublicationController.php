<?php

namespace App\Controller\Admin;

use App\Entity\Publication;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPublicationController extends AbstractController
{
    #[Route('/admin/publication', name: 'admin_publication')]
    public function index(EntityManagerInterface $entityManager): Response
    {        
        $publications = $entityManager->getRepository(Publication::class)
            ->createQueryBuilder('p')
            ->where('p.state_validated = false') 
            ->getQuery()
            ->getResult();

        return $this->render('Admin/publication/index.html.twig', [
            'publications'=> $publications,
        ]);
    }

    #[Route('/admin/publication/delete/{idPublication}', name: 'admin_delete_publication')]
    public function deletePublication(EntityManagerInterface $entityManager, $idPublication): Response
    {        
        $publications = $entityManager->getRepository(Publication::class)->find($idPublication);
        if (!$publications) {
            $this->addFlash('error', 'La publication n\'existe pas');
        } else {
            // Supprimer l'entité
            $entityManager->remove($publications);
            $entityManager->flush();
            $this->addFlash('success', 'La publication à été supprimée avec succès.');
        }
        return $this->redirectToRoute('admin_publication');
    }

    #[Route('/admin/publication/state/{idPublication}', name: 'state_validated_publication')]
    public function stateValidatedPublication(EntityManagerInterface $entityManager, $idPublication): Response
    {        
        $publications = $entityManager->getRepository(Publication::class)->find($idPublication);
        if (!$publications) {
            $this->addFlash('error', 'La publication n\'existe pas');
        } else {
            $publications->setStateValidated(true);
            $entityManager->persist($publications);
            $entityManager->flush();
            $this->addFlash('success', 'La publication à été vérifié.');
        }
        return $this->redirectToRoute('admin_publication');
    }
}
