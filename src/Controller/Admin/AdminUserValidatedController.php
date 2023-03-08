<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserValidatedController extends AbstractController
{
    #[Route('/admin/user/validated', name: 'admin_user_validated')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $qb = $entityManager->createQueryBuilder();
        $usersNoValidated = $qb->select('u')
            ->from(User::class, 'u')
            ->where('u.identity_card_validated = false')
            ->andWhere($qb->expr()->isNotNull('u.identity_card_location'))
            ->andWhere($qb->expr()->neq('u.identity_card_location', $qb->expr()->literal('')))
            ->getQuery()
            ->getResult();

        return $this->render('Admin/user_validated/index.html.twig', [
            'controller_name' => 'AdminUserValidatedController',
            'usersNoValidated' => $usersNoValidated,
        ]);
    }

    #[Route('/admin/user/validated/{idUser}', name: 'adminValidatedUser')]
    public function adminValidatedUser(EntityManagerInterface $entityManager, $idUser): Response
    {
        $users = $entityManager->getRepository(User::class)->find($idUser);
        if (!$users) {
            $this->addFlash('error', 'L\'utilisateur n\'existe pas');
        } else {
            $users->setIdentityCardValidated(true);
            $entityManager->persist($users);
            $entityManager->flush();
            $this->addFlash('success', 'L\'utilisateur à été verifié.');
        }
        return $this->redirectToRoute('admin_user_validated');
    }

    #[Route('/admin/user/delete/identityCard/{idUser}', name: 'adminCancelUser')]
    public function adminCancelUser(EntityManagerInterface $entityManager, $idUser): Response
    {
        $users = $entityManager->getRepository(User::class)->find($idUser);
        if (!$users) {
            $this->addFlash('error', 'L\'utilisateur n\'existe pas');
        } else {
            $users->setIdentityCardLocation("");
            $users->setIdentityCardValidated(false);
            $entityManager->persist($users);
            $entityManager->flush();
            $this->addFlash('success', 'Le justificatif à été supprimé');
        }
        return $this->redirectToRoute('admin_user_validated');
    }
}
