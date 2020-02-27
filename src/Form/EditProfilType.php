<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


class EditProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('name', null, [
              'required' => true,
              'label' => "Nom",
            ])

            ->add('firstname', null, [
              'required' => true,
              'label' => "Prénom",
            ])

            ->add('avatar', Filetype::class, [
              'label' => "Avatar (jpg)",
              'required' => false,
              'mapped' => false,
              'attr' => ['placeholder' => 'Choisir fichier'],
              'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Seul les fichier JPG et de moins de 2mo sont accepter',
                    ])
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
