<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, [
                'attr' => [
                    'class' => 'input is-rounded',
                    'placeholder' => 'Prénom'
                ]

            ])
            ->add('last_name', TextType::class, [
                'attr' => [
                    'class' => 'input is-rounded',
                    'placeholder' => 'Nom'

                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'input is-rounded'

                ]
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input is-rounded',
                    'min' => "1960-01-01",
                    'max' => "2004-01-01",

                    'placeholder' => 'Date de naissance'

                ],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
