<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserIdentityCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('identityCardLocation', FileType::class,[
                'label' => 'Importer votre justificatif',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'label_attr' => [
                    'class' => 'text-main-blue text-lg lg:text-xl mb-5'
                ],
                'attr' => [
                    'placeholder' => 'Importer votre justificatif',
                    'class' => 'py-4 border text-main-white mt-1 rounded px-4 w-full bg-gray-50'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'my-8 w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-blue1 rounded-md hover:text-main-blue hover:bg-main-light-blue focus:outline-none focus:bg-blue-400 focus:ring focus:ring-blue-300 focus:ring-opacity-50'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
