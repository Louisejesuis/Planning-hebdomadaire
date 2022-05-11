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
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'is-size-5 '
                ],
                'attr' => [
                    'class' => 'input is-small'
                ]

            ])
            ->add('last_name', TextType::class, [
                'label' => 'Nom de famille',
                'label_attr' => [
                    'class' => 'is-size-5 '
                ],
                'attr' => [
                    'class' => 'input is-small'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'invalid_message' => 'Le format n\'est pas le bon',
                'label_attr' => [
                    'class' => 'is-size-5 '
                ],
                'attr' => [
                    'placeholder' => 'example@example.fr',
                    'class' => 'input is-small'

                ]
            ])
            ->add('birthday', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'label_attr' => [
                    'class' => 'is-size-5 '
                ],
                'attr' => [
                    'class' => 'input',
                    'value' => "1995-01-01"
                ],

            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'is-size-5 '
                ],
                'attr' => [
                    'class' => 'input is-small'
                ],
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
                'attr' => ['class' => 'button mt-2'],
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
