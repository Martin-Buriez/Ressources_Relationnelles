<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\CommentConcernPublication;
use App\Entity\Image;
use App\Entity\Publication;
use App\Entity\PublicationIncludeImage;
use App\Entity\User;
use App\Entity\UserEditComment;
use App\Form\CommentType;
use App\Services\PaginationServices;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function show(EntityManagerInterface $entityManager, Request $request, $slug, PaginationServices $pagination, $page)
    {
        $userConnected = $this->getUser();
        $userProfile = $entityManager->getRepository(User::class)->findOneById($userConnected);
        $publication = $entityManager->getRepository(Publication::class)->findOneBySlug($slug);

        // Incrémenter le nombre de vues de la publication
        if ($publication) {
            $publication->setViewNumber($publication->getViewNumber() + 1);
            $entityManager->persist($publication);
            $entityManager->flush();
        }

        $comments = $entityManager->getRepository(CommentConcernPublication::class)
            ->createQueryBuilder('c')
            ->where('c.publication = :publication') 
            ->setParameter('publication', $publication)
            ->getQuery()
            ->getResult();

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            // Liaison commentaire a la publication
            $commentConcernPublication = new CommentConcernPublication();
            $commentConcernPublication->setComment($comment);
            $commentConcernPublication->setPublication($publication);
            $entityManager->persist($commentConcernPublication); 

            // Liaison commentaire au créateur
            $userEditComment = new UserEditComment();
            $userEditComment->setComment($comment);
            $userEditComment->setUser($userProfile);
            $entityManager->persist($userEditComment); 

            //Set date de création
            $dateTimeZone = new DateTimeZone('Europe/Paris');
            $date = new \DateTimeImmutable('now', $dateTimeZone);
            $comment->setCreatedAt($date);

            $comment->setReportedStatus(false);
            
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash(
                'comment_create_succes',
                'Votre commentaire a bien été ajouté !'
            );
        }

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
            'commentForm' => $commentForm,
            'comments' => $comments,
        ]);
    }
    // #[Route('/les-publications/{slug}/{page<\d+>?1}', name: 'like_publication', requirements: ["page" => "\d+"])]
    // public function like(EntityManagerInterface $entityManager, Request $request, $slug, PaginationServices $pagination, $page)
    // {
    //     $publication = $entityManager->getRepository(Publication::class)->findOneBySlug($slug);
    //     if ($publication) {
    //         $publication->setViewNumber($publication->getViewNumber() + 1);
    //         $entityManager->persist($publication);
    //         $entityManager->flush();
    //     }
    //     return $this->render('publication/index.html.twig', [
    //         'publication' => $publication,
    //     ]);
    // }
}