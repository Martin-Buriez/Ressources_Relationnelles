<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserRelationship;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class UserFriendController extends AbstractController
{
    #[Route('/mon-profil/invitations', name: 'user_invitations')]
    public function index(EntityManagerInterface $entityManager, Request $request, Security $security ): Response
    {

        $user = $this->getUser();
        $userProfile = $entityManager->getRepository(User::class)->findOneById($user);
        $userRequest = $entityManager->getRepository(UserRelationship::class)
            ->createQueryBuilder('r')
            ->where('r.state = false AND r.userSender != :userProfile') 
            ->setParameter('userProfile', $userProfile)
            ->getQuery()
            ->getResult();

        $userFilter = [];
        $search = $request->query->get('search');
        if ($search) {
            $userFilter = $entityManager->getRepository(User::class)->findBySearch($search);
        }
        return $this->render('user_invitations/index.html.twig', [
            'controller_name' => 'UserFriendController',
            'userFilter' => $userFilter,
            'userRequest' => $userRequest,
        ]);
    }

    #[Route('/mon-profil/invitations/add/{idUserReceive}/{idUserSender}', name: 'user_add_friend')]
    public function userAddFriend(Request $request, EntityManagerInterface $entityManager, Security $security, $idUserReceive, $idUserSender): RedirectResponse
    {
        // Récupérer le profil de l'utilisateur
        $userSender = $entityManager->getRepository(User::class)->find($idUserSender);
        $userReceive = $entityManager->getRepository(User::class)->find($idUserReceive);
        // Vérifier si la relation d'amitié n'existe pas déjà
        $Relationship = $entityManager->getRepository(UserRelationship::class);
        $userRelationship = $Relationship->findUserRelationship($userSender, $userReceive);
        if(!$userRelationship){
            // Créer une nouvelle entité "Amis"
            $friend = new UserRelationship();
            $friend->setUserSender($userSender);
            $friend->setUserReceive($userReceive);
            $friend->setState(False);
            $dateTimeZone = new DateTimeZone('Europe/Paris');
            $date = new \DateTimeImmutable('now', $dateTimeZone);
            $friend->setCreatedAt($date);
            // Enregistrer l'entité dans la base de données
            $entityManager->persist($friend);
            $entityManager->flush();
        }else{
            $this->addFlash('Erreur','Vous avez déja cet utilisateur en ami');
        }
        // Rediriger vers la page d'accueil des amis
        return $this->redirectToRoute('user_friend_list');
    }

    #[Route('/mon-profil/invitations/delete/{idRelationShip}', name: 'user_delete_invitation')]
    public function userDeleteInvitation($idRelationShip, EntityManagerInterface $entityManager)
    {
        // Récupérer l'entité UserRelationship correspondante
        $userRelationship = $entityManager->getRepository(UserRelationship::class)->find($idRelationShip);
        // Vérifier si l'entité existe
        if (!$userRelationship) {
            $this->addFlash('error', 'La relation d\'amitié n\'existe pas.');
        } else {
            // Supprimer l'entité
            $entityManager->remove($userRelationship);
            $entityManager->flush();
            $this->addFlash('success', 'La relation d\'amitié a été supprimée avec succès.');
        }
        // Rediriger vers la page d'accueil des amis
        return $this->redirectToRoute('user_invitations');
    }

    #[Route('/mon-profil/invitations/accept/{idRelationShip}', name: 'user_accepte_invitation')]
    public function userAddInvitation($idRelationShip, EntityManagerInterface $entityManager)
    {
        // Récupérer l'entité UserRelationship correspondante
        $userRelationship = $entityManager->getRepository(UserRelationship::class)->find($idRelationShip);
        // Modifier l'état de la relation en True (ami accepté)
        $userRelationship->setState(true);
        // Enregistrer l'entité modifiée dans la base de données
        $entityManager->flush();
        // Ajouter un message flash pour indiquer que la demande a été acceptée
        $this->addFlash('success', 'La demande d\'ami a été acceptée avec succès.');
        // Rediriger vers la page des amis
        return $this->redirectToRoute('user_invitations');
    }
}
