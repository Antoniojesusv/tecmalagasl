<?php

namespace App\Form;

use App\Entity\Characteristic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType as SymfonyTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacteristicType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', SymfonyTextType::class, [
                'label' => 'Nombre',
                'required' => true,
            ])
            ->add('value', SymfonyTextType::class, [
                'label' => 'Valor',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Characteristic::class,
        ]);
    }
}
