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
use Symfony\Component\Validator\Constraints\File;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
              'label' => 'Nom *'
            ])
            ->add('description', null, [
              'label' => 'Description *'
            ])
            ->add('imageHome', Filetype::class, [
              'label' => "Image de la page d'accueil *",
              'required' => true,
              'mapped' => false,
              'attr' => ['placeholder' => 'Choisir fichier']
            ])

            ->add('imageBackground', Filetype::class, [
              'label' => "Background de la page *",
              'required' => true,
              'mapped' => false,
              'attr' => ['placeholder' => 'Choisir fichier']
            ])
            ->add('groupe', null, [
              'label' => 'Groupe *'
            ])
            ->add('user')

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
