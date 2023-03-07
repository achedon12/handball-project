<?php

namespace App\Form;

use App\Entity\Equipes;
use App\Entity\Matches;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class CreateMatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipe_locale', EntityType::class,[
                'class'=>Equipes::class,
                'choice_label'=>'libelle',
            ])
            ->add('domicile_exterieur', ChoiceType::class,[
                    'choices'=>[
                        'Extérieur'=>0,
                        'Domicile'=>1
                    ],
                    'expanded'=>true,
                    'multiple'=>false,

            ]
        )
            ->add('equipe_adverse')
            ->add('hote')
            ->add('date_heure')
            ->add('num_semaine')
            ->add('num_journee')
            ->add('gymnase')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matches::class,
        ]);
    }
}
