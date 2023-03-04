<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\User;
use App\Entity\UserBelongGroup;
use App\Entity\UserRelationship;
use App\Form\GroupType;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserManageGroupsController extends AbstractController
{
    #[Route('/mon-profil/groupes', name: 'user_manage_groups')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();
        $groupSelected = '';
        $userInGroupe = [] ;
        $userProfile = $entityManager->getRepository(User::class)->findOneById($user);

        $userFriends = $entityManager->getRepository(UserRelationship::class)
            ->createQueryBuilder('r')
            ->where('r.userSender = :userProfile AND r.state = true OR r.userReceive = :userProfile AND r.state = true')
            ->setParameter('userProfile', $userProfile)
            ->getQuery()
            ->getResult();
        
        $userSupervisorGroups = $entityManager->getRepository(UserBelongGroup::class)
            ->createQueryBuilder('b')
            ->where('b.user = :userProfile AND b.IsSupervisor = true')
            ->setParameter('userProfile', $userProfile)
            ->getQuery()
            ->getResult();

        $group = new Group();
        $groupForm = $this->createForm(GroupType::class, $group);
        $groupForm->handleRequest($request);
    
        if ($groupForm->isSubmitted() && $groupForm->isValid()) {
            $userIncludeGroup = new UserBelongGroup();
            $userIncludeGroup->setUser($userProfile);
            $userIncludeGroup->setGroupe($group);
            $userIncludeGroup->setIsSupervisor(true);
            $entityManager->persist($userIncludeGroup);

            //Set date de création
            $dateTimeZone = new DateTimeZone('Europe/Paris');
            $date = new \DateTimeImmutable('now', $dateTimeZone);
            $group->setCreatedAt($date);

            $entityManager->persist($group);
            $entityManager->flush();
            $this->addFlash(
                'group_create_success',
                'Votre groupe a bien été ajouté !'
            );
            return $this->redirectToRoute('user_manage_groups');
        }
        return $this->render('user_manage_groups/index.html.twig', [
            'controller_name' => 'UserManageGroupsController',
            'userFriends' => $userFriends,
            'groupForm' => $groupForm->createView(),
            'userSupervisorGroups' => $userSupervisorGroups,
            'userInGroupe'=>$userInGroupe,
            'groupSelected'=>$groupSelected,
        ]);
        
    }

    #[Route('/mon-profil/groupes/show/{idGroup}', name: 'user_show_participant_group')]
    public function showParticipantGroup(EntityManagerInterface $entityManager, Request $request, $idGroup): Response
    {
        $user = $this->getUser();
        $userInGroupe = [] ;
        $userProfile = $entityManager->getRepository(User::class)->findOneById($user);

        $userFriends = $entityManager->getRepository(UserRelationship::class)
            ->createQueryBuilder('r')
            ->where('r.userSender = :userProfile AND r.state = true OR r.userReceive = :userProfile AND r.state = true')
            ->setParameter('userProfile', $userProfile)
            ->getQuery()
            ->getResult();
        
        $userSupervisorGroups = $entityManager->getRepository(UserBelongGroup::class)
            ->createQueryBuilder('b')
            ->where('b.user = :userProfile AND b.IsSupervisor = true')
            ->setParameter('userProfile', $userProfile)
            ->getQuery()
            ->getResult();

        $group = new Group();
        $groupForm = $this->createForm(GroupType::class, $group);
        $groupForm->handleRequest($request);
    
        if ($groupForm->isSubmitted() && $groupForm->isValid()) {
            $userIncludeGroup = new UserBelongGroup();
            $userIncludeGroup->setUser($userProfile);
            $userIncludeGroup->setGroupe($group);
            $userIncludeGroup->setIsSupervisor(true);
            $entityManager->persist($userIncludeGroup);

            //Set date de création
            $dateTimeZone = new DateTimeZone('Europe/Paris');
            $date = new \DateTimeImmutable('now', $dateTimeZone);
            $group->setCreatedAt($date);

            $entityManager->persist($group);
            $entityManager->flush();
            $this->addFlash(
                'group_create_success',
                'Votre groupe a bien été ajouté !'
            );
            return $this->redirectToRoute('user_manage_groups');
        }

        $groupSelected = $entityManager->getRepository(Group::class)->find($idGroup);

        $userInGroupe = $entityManager->getRepository(UserBelongGroup::class)
            ->createQueryBuilder('b')
            ->where('b.groupe = :idGroup AND b.IsSupervisor = false')
            ->setParameter('idGroup', $idGroup)
            ->getQuery()
            ->getResult();

        return $this->render('user_manage_groups/index.html.twig', [
            'controller_name' => 'UserManageGroupsController',
            'userFriends' => $userFriends,
            'groupForm' => $groupForm->createView(),
            'userSupervisorGroups' => $userSupervisorGroups,
            'userInGroupe' => $userInGroupe,
            'groupSelected' => $groupSelected,
        ]);
    }

    #[Route('/mon-profil/groupes/add/{idGroup}/addUser/{idUser}', name: 'user_add_participant_group')]
    public function addParticipantInGroup(EntityManagerInterface $entityManager, Request $request, $idGroup, $idUser): Response
    {
        $userEntity = $entityManager->getRepository(User::class)->findOneById($idUser);
        $groupEntity = $entityManager->getRepository(Group::class)->findOneById($idGroup);

        $userGroupEntity = $entityManager->getRepository(UserBelongGroup::class)->findOneBy([
            'user' => $userEntity,
            'groupe' => $groupEntity
        ]);
        if ($userGroupEntity !== null) {
            $this->addFlash(
                'error',
                'Votre ami est déja dans votre groupe !'
            );
        }else{
            $addGroup = new UserBelongGroup();
            $addGroup->setUser($userEntity);
            $addGroup->setGroupe($groupEntity);
            $addGroup->setIsSupervisor(false);
            // Enregistrer l'entité dans la base de données
            $entityManager->persist($addGroup);
            $entityManager->flush();
            $this->addFlash(
                'succes',
                'Votre ami est ajouté(e) dans votre groupe!'
            );
        }
        // Rediriger vers la page d'accueil des amis
        return $this->redirectToRoute('user_manage_groups');
    }

    #[Route('/mon-profil/groupes/delete/{idUserBelongGroup}', name: 'user_delete_participant_group')]
    public function deleteParticipantInGroup(EntityManagerInterface $entityManager, Request $request, $idUserBelongGroup): Response
    {
        $userGroupEntity = $entityManager->getRepository(UserBelongGroup::class)->findOneById($idUserBelongGroup);

        if ($userGroupEntity !== null) {
            $entityManager->remove($userGroupEntity);
            $entityManager->flush();
            $this->addFlash(
                'succes',
                'Votre ami est supprimé(e) du groupe !'
                
            );
        }else{
            $this->addFlash(
                'error',
                'Votre ami n\'est pas présent dans votre groupe!'
            );
        }
        // Rediriger vers la page d'accueil des amis
        return $this->redirectToRoute('user_manage_groups');
    }
}