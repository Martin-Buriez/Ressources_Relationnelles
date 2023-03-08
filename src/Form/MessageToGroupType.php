<?php

namespace App\Form;

use App\Entity\UserCommunicateGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageToGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextType::class, [
                'label' => false,
                'label_attr'=> [
                    'class' => 'font-semibold'
                ],
                'attr' => [
                    'rows' => '15',
                    'placeholder' => 'Saisir votre message',
                    'class' => 'form-input block w-full px-4 py-3 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-800 rounded-2xl dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40'
                ]
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
            'data_class' => UserCommunicateGroup::class,
        ]);
    }
}
