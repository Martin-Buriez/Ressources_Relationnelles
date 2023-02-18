<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Publication;
use App\Entity\PublicationIncludeImage;
use App\Form\PublicationType;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAddPublicationController extends AbstractController
{
    #[Route('/ajouter-publication', name: 'add_publication')]
    public function index(EntityManagerInterface $entityManager, Request $request, string $publicationImageDir): Response
    {
        $publication = new Publication();
        $publicationForm = $this->createForm(PublicationType::class, $publication);
        $publicationForm->handleRequest($request);

        if($publicationForm->isSubmitted() && $publicationForm->isValid()){
            //On traite les thèmes
            $publicationTheme = $publicationForm->get('theme')->getData();
            $publication->setTheme($publicationTheme);

            // On traite les images
            $publicationImages = $publicationForm->get('images')->getData();
            foreach ($publicationImages as $publicationImage){
                $publicationImageFilename = bin2hex(random_bytes(6)).'.'.$publicationImage->guessExtension();
                try {
                    $publicationImage->move($publicationImageDir, $publicationImageFilename);
                } catch (FileException $e){
                    $this->addFlash('error_upload_publication_image', 'Une erreur est survenue lors de l\'upload de l\'image');
                }
                $img = new Image();
                $img->setName($publicationImageFilename);
                $entityManager->persist($img); // Ajout de l'entité Image à la base de données
                $imgIncludePublication = new PublicationIncludeImage();
                $imgIncludePublication->setImage($img);
                $imgIncludePublication->setPublication($publication);
                $entityManager->persist($imgIncludePublication); // Ajout de l'entité PublicationIncludeImage à la base de données
            }

            // On traite les valeurs par défauts
            $publicationStatePrivate = $publicationForm->get('state_private')->getData();
            if ($publicationStatePrivate = false){
                $publication->setStatePrivate(false);
            } else {
                $publication->setStatePrivate($publicationStatePrivate);
            }
            $publication->setStateValidated(False);
            $publication->setLikeNumber(0);
            $publication->setSharingNumber(0);
            $publication->setViewNumber(0);

            //On traite la categorie de la ressource
            // $publicationCategory = $publicationForm->get('category')->getData();
            // $publicationReferencerCategory = new PublicationReferencerCategory();
            // $publicationReferencerCategory->setCategory($publicationCategory);
            // $publicationReferencerCategory->setPublication($publication);

            //Set Id du créateur
            $publication->setCreatedBy($this->getUser());

            //Set date de création
            $dateTimeZone = new DateTimeZone('Europe/Paris');
            $date = new \DateTime('now', $dateTimeZone);
            $publication->setCreatedAt($date);

            $entityManager->persist($publication);
            $entityManager->flush();
            $this->addFlash(
                'publication_create_success',
                'Votre article a bien été ajouté !'
            );
            return $this->redirectToRoute('user_publication');
        }

        return $this->render('user_add_publication/index.html.twig', [
            'controller_name' => 'UserAddPublicationController',
            'publicationForm' => $publicationForm,
        ]);
    }
}
