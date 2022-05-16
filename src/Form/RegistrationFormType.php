<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegistrationFormType extends AbstractType
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

            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit être au moins de {{ limit }} cara',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'button is-rounded is-primary is-outlined'],
                'label' => 'Créer un compte'

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
