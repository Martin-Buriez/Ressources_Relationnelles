<?php

namespace App\Form;

use App\Entity\Category;
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
            ->add('theme', EntityType::class, [
                'label' => 'Thème :',
                'class' => Theme::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label_attr'=> [
                    'class' => 'font-semibold'
                ],
                'attr' => [
                    'class' => 'form-input block w-3/12 px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40'
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie :',
                'class' => Category::class,
                'choice_label' => 'title',
                'choice_value' => 'id',
                'label_attr'=> [
                    'class' => 'font-semibold'
                ],
                'attr' => [
                    'class' => 'form-input block w-3/12 px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40'
                ]
            ])
            ->add('title', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Titre de votre ressource',
                    'class' => 'form-input block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de la ressource :',
                'label_attr'=> [
                    'class' => 'font-semibold'
                ],
                'attr' => [
                    'rows' => '15',
                    'placeholder' => 'Saisir la description de la ressource',
                    'class' => 'form-input block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40'
                ]
            ])
            ->add('state_private', CheckboxType::class, [
                'label' => 'Ceci est une ressource privée',
                'required' => false,
                'label_attr'=> [
                    'class' => 'font-semibold'
                ],
                'attr' => [
                    'placeholder' => 'Saisir le status de la ressource',
                    'class' => 'px-4 ml-4'
                ]
            ])
            ->add('images', FileType::class,[
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Importer les images de la ressource',
                    'class' => 'py-6 px-20 border w-full'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-blue1 rounded-md hover:text-main-blue hover:bg-main-light-blue focus:outline-none focus:bg-blue-400 focus:ring focus:ring-blue-300 focus:ring-opacity-50'
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
