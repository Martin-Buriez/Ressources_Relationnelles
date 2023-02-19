<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Publication;
use App\Entity\PublicationIncludeImage;
use App\Entity\User;
use App\Services\PaginationServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
    #[Route('/les-publications/{page<\d+>?1}', name: 'publication', requirements: ["page" => "\d+"])]
    public function index(EntityManagerInterface $entityManager, PaginationServices $pagination, $page): Response
    {
        $pagination
            ->setOrderBy(['created_at' => 'DESC'])
            ->setPage($page)
            ->setLimit(3)
            ->setEntityClass(Publication::class)
            ->setCriteria([]);
        $paginatePublications = $pagination->getData();
        return $this->render('publication/index.html.twig', [
            'publications' => $paginatePublications,
            'pages' => $pagination->getPages(),
            'page' => $page,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Permet d'afficher le détail d'un blog
     * @return Response
     * @throws Exception
     */
    #[Route('/les-publications/{slug}/{page<\d+>?1}', name: 'publication_show', requirements: ["page" => "\d+"])]
    public function show(EntityManagerInterface $entityManager, $slug, PaginationServices $pagination, $page)
    {
        $publication = $entityManager->getRepository(Publication::class)->findOneBySlug($slug);
        
        $pagination
            ->setOrderBy(['created_at' => 'DESC'])
            ->setPage($page)
            ->setLimit(7)
            ->setEntityClass(Publication::class)
            ->setCriteria(['title' => $publication]);

        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
            'pages' => $pagination->getPages(),
            'page' => $page,
            'pagination' => $pagination,
        ]);
    }
}
