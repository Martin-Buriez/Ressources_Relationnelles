<?php

namespace App\Controller;

use App\Entity\Publication;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserIdentityCardType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends AbstractController
{
    #[Route('/mon-profil', name: 'profile')]
    public function index(EntityManagerInterface $entityManager, Request $request, string $userIdentityCardDir): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        
        /**
         * Retourne le nombre de ressource créé par l'utilisateur
         */
        $query = $entityManager->createQuery(
            'SELECT COUNT(p.id) FROM App\Entity\Publication p WHERE p.created_by = :user'
        )->setParameter('user', $user);
        $NbrRessource = $query->getSingleScalarResult();

        $userCardForm = $this->createForm(UserIdentityCardType::class, $user);
        $userCardForm->handleRequest($request);

        if ($userCardForm->isSubmitted() && $userCardForm->isValid()) {
            $userImages = $userCardForm->get('identityCardLocation')->getData();
            foreach ($userImages as $userImage){
                $userImageFilename = bin2hex(random_bytes(6)).'.'.$userImage->guessExtension();
                try {
                    $userImage->move($userIdentityCardDir, $userImageFilename);
                } catch (FileException $e){
                    $this->addFlash('error_upload', 'Une erreur est survenue lors de l\'upload de l\'image');
                }
                $user->setIdentityCardLocation($userImageFilename);
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'justificatif_create_success',
                'Votre justificatif a bien été ajouté !'
            );
        }   

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user'=> $user,
            'userCardForm' => $userCardForm,
            'NbrRessource' => $NbrRessource,
        ]);
    }
}
