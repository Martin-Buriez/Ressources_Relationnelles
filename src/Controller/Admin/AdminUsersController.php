<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUsersController extends AbstractController
{
    #[Route('/admin/users', name: 'admin_users')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $userFilter = [];
        $userFilter = $entityManager->getRepository(User::class)
            ->createQueryBuilder('u')
            ->orderBy('u.created_at', 'DESC')
            ->getQuery()
            ->getResult();
            
        $search = $request->query->get('search');
        if ($search) {
            $userFilter = $entityManager->getRepository(User::class)->findBySearch($search);
        }
        return $this->render('Admin/users/index.html.twig', [
            'userFilter' => $userFilter,
        ]);
    }

    #[Route('/admin/users/promote/{idUser}', name: 'admin_promote_users')]
    public function adminPromoteUser(EntityManagerInterface $entityManager, Request $request, $idUser): Response
    {
        $user = $entityManager->getRepository(User::class)->find($idUser);
        if (!$user) {
            $this->addFlash('error', 'l\'utilisateur n\'existe pas');
        } else {
            $user->setRoles(["ROLE_ADMIN"]);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'l\'utilisateur à été promu(e).');
        }
        return $this->redirectToRoute('admin_users');
    }

    #[Route('/admin/users/removing/{idUser}', name: 'admin_removing_users')]
    public function adminRemovingUser(EntityManagerInterface $entityManager, Request $request, $idUser): Response
    {
        $user = $entityManager->getRepository(User::class)->find($idUser);
        if (!$user) {
            $this->addFlash('error', 'l\'utilisateur n\'existe pas');
        } else {
            $user->setRoles([""]);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'l\'utilisateur à été déstitué(e).');
        }
        return $this->redirectToRoute('admin_users');
    }
}