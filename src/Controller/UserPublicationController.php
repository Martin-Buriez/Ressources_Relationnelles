<?php

namespace App\Controller;

use App\Entity\Publication;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserPublicationController extends AbstractController
{
    #[Route('/mon-profil/mes-publications', name: 'user_publication')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $publications =  $entityManager->getRepository(Publication::class)->findAll();

        return $this->render('user_publication/index.html.twig', [
            'controller_name' => 'UserPublicationController',
        ]);
    }
}
