<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentsController extends AbstractController
{
    #[Route('/admin/comments', name: 'admin_comments')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $comments = $entityManager->getRepository(Comment::class)
            ->createQueryBuilder('c')
            ->where('c.reportedStatus = true') 
            ->getQuery()
            ->getResult();
        
        return $this->render('Admin/comments/index.html.twig', [
            'controller_name' => 'AdminCommentsController',
            'comments' => $comments,
        ]);
    }

    #[Route('/admin/comments/delete/{idComment}', name: 'delete_comments')]
    public function deleteComment(EntityManagerInterface $entityManager, $idComment): Response
    {
        $comments = $entityManager->getRepository(Comment::class)->find($idComment);
        if (!$comments) {
            $this->addFlash('error', 'Le commentaire n\'existe pas');
        } else {
            // Supprimer l'entité
            $entityManager->remove($comments);
            $entityManager->flush();
            $this->addFlash('success', 'La commentaire à été supprimée avec succès.');
        }
        return $this->redirectToRoute('admin_comments');
    }

    #[Route('/admin/comments/cancelReported/{idComment}', name: 'cancel_reported_comments')]
    public function cancelReportedComment(EntityManagerInterface $entityManager, $idComment): Response
    {
        $comments = $entityManager->getRepository(Comment::class)->find($idComment);
        if (!$comments) {
            $this->addFlash('error', 'Le commentaire n\'existe pas');
        } else {
            $comments->setReportedStatus(false);
            $entityManager->persist($comments);
            $entityManager->flush();
            $this->addFlash('success', 'La commentaire à été vérifié.');
        }
        return $this->redirectToRoute('admin_comments');
    }
}
