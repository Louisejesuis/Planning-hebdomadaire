<?php

namespace App\Form;

use App\Entity\UserSteps;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Step;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserStepsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['selected_date'] == false) {
            $options['selected_date'] = $options['data']->getDate();
        }
        if ($options['data']->getDuration() == false) {
            $options['selected_duration'] = '00:00';
        } else {
            $options['selected_duration'] = $options['data']->getDuration()->format('H:i');
        }
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
                'attr' => [
                    'class' => 'input',
                    'value' => $options['selected_date']->format('Y-m-d')

                ],
                'label_attr' => [
                    'class' => 'is-size-5 '
                ],
            ])
            ->add('duration', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Durée',
                'attr' => [
                    'class' => 'input',
                    'value' => $options['selected_duration']
                ],
                'label_attr' => [
                    'class' => 'is-size-5 '
                ],
            ])
            ->add('step', EntityType::class, [
                'class' => Step::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'select'
                ],
                'label' => 'Démarche',
                'label_attr' => [
                    'class' => 'is-size-5 '
                ],
            ])
            ->add('comment', TextareaType::class, [
                'attr' => [
                    'class' => 'textarea'
                ],
                'label' => 'Commentaire',
                'label_attr' => [
                    'class' => 'is-size-5 '
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'button mt-2'],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserSteps::class,
            'selected_date' => null
        ]);
    }
}
