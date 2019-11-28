<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as SymfonyTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['requireImage']) {
            $builder
                ->add('fileName', FileType::class, [
                    'label' => 'Imagen',
                    'data_class' => null,
                    'mapped' => 'false',
                    'required' => true,
                    'attr'     => [
                        'accept' => 'image/*',
                        'multiple' => 'multiple'
                    ]
                ]);
        }
        $builder
            ->add('title', SymfonyTextType::class, [
                'label' => 'Titulo',
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripción'
            ])
            ->add('product', EntityType::class, [
                'label' => 'Producto',
                'class' => Product::class,
                'choice_label' => 'name',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
            'requireImage' => true
        ]);
    }
}
