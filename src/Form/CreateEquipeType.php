<?php

namespace App\Form;

use App\Entity\Equipes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CreateEquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Nom de l\'équipe',
                'attr' => [
                    'placeholder' => 'Nom de l\'équipe',
                ],
            ])
            ->add('entraineur', TextType::class, [
                'label' => 'Entraineur',
                'attr' => [
                    'placeholder' => 'Entraineur',
                ],
            ])
            ->add('creneaux', TextType::class, [
                'label' => 'Créneaux',
                'attr' => [
                    'placeholder' => 'Créneaux',
                ],
            ])
            ->add('url_photo', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Sélectionnez une image valide',
                    ])
                ],
            ])
            ->add('url_result_calendrier', TextType::class, [
                'label' => 'Url du calendrier',
                'attr' => [
                    'placeholder' => 'Url du calendrier',
                ],
            ])
            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaire',
                'attr' => [
                    'placeholder' => 'Commentaire',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipes::class,
        ]);
    }
}
