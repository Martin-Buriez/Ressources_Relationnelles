<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAddPublicationController extends AbstractController
{
    #[Route('/ajouter-publication', name: 'add_publication')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $publication = new Publication();
        $publicationForm = $this->createForm(PublicationType::class);
        $publicationForm->handleRequest($request);

        if($publicationForm->isSubmitted() && $publicationForm->isValid()){

            return $this->redirectToRoute('user_articles');
        }

        return $this->render('user_add_publication/index.html.twig', [
            'controller_name' => 'UserAddPublicationController',
            'publicationForm' => $publicationForm->createView(),
        ]);
    }
}
