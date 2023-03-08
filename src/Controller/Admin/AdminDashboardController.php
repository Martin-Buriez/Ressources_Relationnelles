<?php
namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Query\Expr;

class AdminDashboardController extends AbstractController
{
    /**
     * Permet d'afficher la page dashboard de l'administration
     * @return Response
     */
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        //NOMBRE DE PUBLICATIONS
        $query = $entityManager->createQuery(
            'SELECT COUNT(p.id) 
            FROM App\Entity\Publication p'
        );
        $NbrPublication = $query->getSingleScalarResult();
        //COMMENTAIRES
        $query2 = $entityManager->createQuery(
            'SELECT COUNT(c.id) 
            FROM App\Entity\Comment c'
        );
        $NbrComment = $query2->getSingleScalarResult();
        //UTILISATEURS TOTAL
        $query3 = $entityManager->createQuery(
            'SELECT COUNT(u.id) 
            FROM App\Entity\User u'
        );
        $NbrUser = $query3->getSingleScalarResult();
        //PUBLICATIONS À VALIDER
        $query4 = $entityManager->createQuery(
            'SELECT COUNT(p.id) 
            FROM App\Entity\Publication p 
            WHERE p.state_validated = false'
        );
        $NbrPublicationStateFalse = $query4->getSingleScalarResult();
        //COMMENTAIRES SIGNALÉ
        $query4 = $entityManager->createQuery(
            'SELECT COUNT(c.id) 
            FROM App\Entity\Comment c
            WHERE c.reportedStatus = true'
        );
        $NbrCommentReported = $query4->getSingleScalarResult();
        //NOUVEL UTILISATEUR(10Jours)
        $tenDaysAgo = new \DateTime();
        $tenDaysAgo->sub(new \DateInterval('P10D'));
        $query4 = $entityManager->createQuery(
            'SELECT COUNT(u.id) 
            FROM App\Entity\User u
            WHERE DATE_DIFF(CURRENT_DATE(), u.created_at) <= 10'
        );
        $NbrNewUser10days = $query4->getSingleScalarResult();

        return $this->render('Admin/dashboard/index.html.twig', [
            'current_menu' => 'blog',
            'NbrPublication' => $NbrPublication,
            'NbrComment' => $NbrComment,
            'NbrUser' => $NbrUser,
            'NbrPublicationStateFalse' => $NbrPublicationStateFalse,
            'NbrCommentReported' => $NbrCommentReported,
            'NbrNewUser10days' => $NbrNewUser10days,
        ]);
    }
}