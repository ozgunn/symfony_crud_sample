<?php

namespace App\Form;

use App\Entity\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('level', TextType::class)
            ->add('userSkills', EntityType::class,
                [
                    'class' => Skill::class,
                    'choice_label' => 'skill',
                    'multiple' => true,
                    'expanded' => true
                ]
            )
            ->add('save', SubmitType::class)

        ;
    }
}