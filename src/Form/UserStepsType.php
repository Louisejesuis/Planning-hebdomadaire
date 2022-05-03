<?php

namespace App\Form;

use App\Entity\UserSteps;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Step;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserStepsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('duration')
            ->add('comment')
            ->add('step', EntityType::class, [
                'class' => Step::class,
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserSteps::class,
        ]);
    }
}
