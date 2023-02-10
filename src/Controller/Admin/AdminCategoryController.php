<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
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
        $notification = null;
        $categorys = $entityManager->getRepository(category::class)->findAll();

        $category = new Category();
        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);

        if ($categoryForm -> isSubmitted() && $categoryForm->isValid()){
            $category = $categoryForm->getData();
            $search_title = $entityManager->getRepository(category::class)
                ->findOneByTitle($category->getTitle());

            if (!$search_title ) {

                $entityManager->persist($category);
                $entityManager->flush();

                $this->addFlash('success_register', 'Category has been registered');
                return $this->redirectToRoute('admin_category');
            }else {
                $notification = 'La catégories saisit est déjà enregistré sur le site';
            }
        }
    
        return $this->render('Admin/category/index.html.twig', [
            'controller_name' => 'AdminCategoryController',
            'categorys' => $categorys,
            'categoryForm' => $categoryForm,
            'notification' => $notification
        ]);
    }
}
