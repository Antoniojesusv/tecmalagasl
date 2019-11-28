<?php

namespace App\Form;

use App\Entity\BackgroundImage;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BackgroundImageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', EntityType::class, [
                'label' => 'Imagenes',
                'choice_label' => 'title',
                'class' => Image::class,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BackgroundImage::class,
            'constraints' => [
                new UniqueEntity(['fields' => ['image']])
            ],
        ]);
    }
}
