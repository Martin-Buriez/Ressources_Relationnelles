<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserReportedController extends AbstractController
{
    #[Route('/admin/user/reported', name: 'admin_user_reported')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $usersReported = $entityManager->getRepository(User::class)
            ->createQueryBuilder('p')
            ->where('p.state_suspended = true') 
            ->getQuery()
            ->getResult();

        return $this->render('Admin/user_reported/index.html.twig', [
            'controller_name' => 'AdminUserReportedController',
            'usersReported' => $usersReported
        ]);
    }

    #[Route('/admin/user/delete/{idUser}', name: 'admin_user_delete')]
    public function adminDeleteUser(EntityManagerInterface $entityManager, $idUser): Response
    {
        $users = $entityManager->getRepository(User::class)->find($idUser);
        if (!$users) {
            $this->addFlash('error', 'L\'utilisateur n\'existe pas');
        } else {
            // Supprimer l'entité
            $entityManager->remove($users);
            $entityManager->flush();
            $this->addFlash('success', 'L\'utilisateur à été supprimée avec succès.');
        }
        return $this->redirectToRoute('admin_user_reported');
    }

    #[Route('/admin/user/reported/state/{idUser}', name: 'admin_user_changeReported')]
    public function adminReportedUser(EntityManagerInterface $entityManager, $idUser): Response
    {
        $users = $entityManager->getRepository(User::class)->find($idUser);
        if (!$users) {
            $this->addFlash('error', 'L\'utilisateur n\'existe pas');
        } else {
            $users->setStateSuspended(false);
            $entityManager->persist($users);
            $entityManager->flush();
            $this->addFlash('success', 'L\'utilisateur à été debloqué.');
        }
        return $this->redirectToRoute('admin_user_reported');
    }
}
