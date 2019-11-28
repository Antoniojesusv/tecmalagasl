<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Slider;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Image', EntityType::class, [
                'label' => 'Imagen',
                'choice_label' => 'title',
                'class' => Image::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Slider::class,
        ]);
    }
}
