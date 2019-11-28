<?php

namespace App\Form;

use App\Entity\Characteristic;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as SymfonyTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', SymfonyTextType::class, [
                'label' => 'Nombre',
                'required' => true
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Precio',
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descripcion'
            ])
            ->add('characteristic', EntityType::class, [
                'label' => 'Caracteristica',
                'class' => Characteristic::class,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
