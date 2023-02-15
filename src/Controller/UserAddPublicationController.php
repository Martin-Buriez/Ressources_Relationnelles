<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAddPublicationController extends AbstractController
{
    #[Route('/ajouter-publication', name: 'add_publication')]
    public function index(): Response
    {
        return $this->render('user_add_publication/index.html.twig', [
            'controller_name' => 'UserAddPublicationController',
        ]);
    }
}
