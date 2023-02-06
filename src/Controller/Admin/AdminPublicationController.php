<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPublicationController extends AbstractController
{
    #[Route('/admin/publication', name: 'admin_publication')]
    public function index(): Response
    {
        return $this->render('Admin/publication/index.html.twig', [
        ]);
    }
}
