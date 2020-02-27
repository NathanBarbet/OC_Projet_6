<?php

namespace App\Form;

use App\Entity\Tricks;
use App\Entity\Medias;
use App\Form\MediasType;
use App\Form\UserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;

class EditTrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('name', null, [
              'label' => 'Nom *',
              'required' => true
            ])
            ->add('description', TextareaType::class, [
              'label' => 'Description *',
              'required' => false
            ])
            ->add('imageHome', Filetype::class, [
              'label' => "Image de la page d'accueil ",
              'required' => false,
              'mapped' => false,
              'attr' => ['placeholder' => 'Choisir fichier'],
              'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Seul les fichier JPG et de moins de 5mo sont accepter',
                    ])
            ]
            ])

            ->add('imageBackground', Filetype::class, [
              'label' => "Background de la page ",
              'required' => false,
              'mapped' => false,
              'attr' => ['placeholder' => 'Choisir fichier'],
              'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Seul les fichier JPG et de moins de 5mo sont accepter',
                    ])
            ]            ])
            ->add('groupe', null, [
              'label' => 'Groupe *',
              'required' => true
            ])

            ;

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }

}
