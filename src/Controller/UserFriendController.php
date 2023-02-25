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

    #[Route('/mon-profil/friends', name: 'user_friend')]
    public function index(EntityManagerInterface $entityManager, Request $request, Security $security ): Response
    {
        $userEntity = $entityManager->getRepository(User::class)->findAll();
        $userFilter = [];
        
        $search = $request->query->get('search');
        if ($search) {
            $userFilter = $entityManager->getRepository(User::class)->findBySearch($search);
        }
    
        return $this->render('user_friend/index.html.twig', [
            'controller_name' => 'UserFriendController',
            'userFilter' => $userFilter,
            'userEntity' => $userEntity,
        ]);
    }

    #[Route('/mon-profil/friends', name: 'user_add_friend')]
    public function userAddFriend(Request $request, EntityManagerInterface $entityManager, Security $security, $idUserReceive, $idUserSender): RedirectResponse
    {
        // Récuperer le profil de l'utilisateur
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
        return $this->redirectToRoute('user_friend');
    }

    #[Route('/mon-profil/friends', name: 'user_delete_friend')]
    public function userDeleteFriend($idRelationShip, EntityManagerInterface $entityManager)
    {
        // Récupérer l'entité UserRelationship correspondante
        $userRelationship = $entityManager->getRepository(UserRelationship::class)->find($idRelationShip);
    
        // Vérifier si l'entité existe
        if (!$userRelationship) {
            throw $this->createNotFoundException('La relation d\'amitié n\'existe pas.');
        }
    
        // Supprimer l'entité
        $entityManager->remove($userRelationship);
        $entityManager->flush();
    
        // Ajouter un message flash pour indiquer que la relation a été supprimée
        $this->addFlash('success', 'La relation d\'amitié a été supprimée avec succès.');

        // Rediriger vers la page d'accueil des amis
        return $this->redirectToRoute('user_friend');
    }
    
}
