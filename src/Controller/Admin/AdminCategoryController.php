<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    #[Route('/admin/les-categories', name: 'admin_category')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $categorys = $entityManager->getRepository(category::class)->findAll();
    
        return $this->render('Admin/category/index.html.twig', [
            'controller_name' => 'AdminCategoryController',
            'categorys' => $categorys,
        ]);
    }
}
