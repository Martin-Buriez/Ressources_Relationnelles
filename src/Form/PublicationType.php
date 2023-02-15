<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Publication;
use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Le nom de votre ressource',
                'attr' => [
                    'placeholder' => 'Merci de saisir le nom de votre ressource',
                    'class' => 'form-input block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de la ressource',
                'attr' => [
                    'placeholder' => 'Saisir la description de la ressource',
                    'class' => 'form-input block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40'
                ]
            ])
            ->add('state_private', CheckboxType::class, [
                'label' => 'Privée ?',
                'attr' => [
                    'placeholder' => 'Saisir le status de la ressource',
                    'class' => 'form-input block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40'
                ]
            ])
            ->add('theme', EntityType::class, [
                'label' => 'Thème de la ressource',
                'class' => Theme::class,
                'choice_label' => 'name',
            ])
            ->add('name', FileType::class,[
                'label' => 'Importer des images pour cet article',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'label_attr' => [
                    'class' => 'text-main-blue text-lg lg:text-xl mb-5'
                ],
                'attr' => [
                    'placeholder' => 'Importer les images de l\'article',
                    'class' => 'py-4 border text-main-white mt-1 rounded px-4 w-full bg-gray-50'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'my-8 w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-main-blue rounded-md hover:text-main-blue hover:bg-main-light-blue focus:outline-none focus:bg-blue-400 focus:ring focus:ring-blue-300 focus:ring-opacity-50'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
