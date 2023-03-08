<?php

namespace App\Controller\Admin;

use App\Entity\Theme;
use App\Form\ThemeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminThemesController extends AbstractController
{
    #[Route('/admin/themes', name: 'admin_themes')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $notification = null;
        $themes = $entityManager->getRepository(Theme::class)->findAll();

        $theme = new Theme();
        $themeForm = $this->createForm(ThemeType::class, $theme);
        $themeForm->handleRequest($request);

        if ($themeForm -> isSubmitted() && $themeForm->isValid()){
            $theme = $themeForm->getData();
            $search_title = $entityManager->getRepository(Theme::class)
                ->findOneByName($theme->getName());
            if (!$search_title ) {
                $entityManager->persist($theme);
                $entityManager->flush();
                $this->addFlash('success_register', 'Le thème has been registered');
                return $this->redirectToRoute('admin_themes');
            }else {
                $notification = 'Le thème saisit est déjà enregistré sur le site';
            }
        }

        return $this->render('Admin/themes/index.html.twig', [
            'controller_name' => 'AdminThemesController',
            'themes' => $themes,
            'themeForm' => $themeForm,
            'notification' => $notification
        ]);
    }

    #[Route('/admin/themes/delete/{idTheme}', name: 'delete_themes')]
    public function deleteThemes(EntityManagerInterface $entityManager, Request $request, $idTheme): Response
    {
        $themes = $entityManager->getRepository(Theme::class)->findOneById($idTheme);
        if ($themes != null){
            $entityManager->remove($themes);
            $entityManager->flush();
            $this->addFlash(
                'succes',
                'Le thème est supprimé!'
            );
        }else{
            $notification = 'Le thème saisit est déjà enregistré sur le site';
        }
        return $this->redirectToRoute('admin_themes');
    }
}
