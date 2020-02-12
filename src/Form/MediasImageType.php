<?php

namespace App\Form;

use App\Entity\Medias;
use App\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class MediasImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageMedias', Filetype::class, [
              'label' => "Image (jpg) *",
              'required' => true,
              'mapped' => false,
              'attr' => ['placeholder' => 'Choisir fichier']
            ])
            ->add('type', HiddenType::class)
            ->add('tricks', HiddenType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medias::class,
        ]);
    }
}
