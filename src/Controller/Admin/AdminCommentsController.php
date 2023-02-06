<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentsController extends AbstractController
{
    #[Route('/admin/comments', name: 'admin_comments')]
    public function index(): Response
    {
        return $this->render('Admin/comments/index.html.twig', [
            'controller_name' => 'AdminCommentsController',
        ]);
    }
}
