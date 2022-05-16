<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('first_name', TextType::class, [
                'attr' => [
                    'class' => 'input is-rounded',
                ]

            ])
            ->add('last_name', TextType::class, [
                'attr' => [
                    'class' => 'input is-rounded',

                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'input is-rounded'

                ]
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input is-rounded',
                ],

            ]);
        if (in_array('ROLE_ADMIN', $options['current_user_roles'])) {
            $builder->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles'
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'current_user_roles' => json_encode(['ROLE_USER'])

        ]);
    }
}
