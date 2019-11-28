<?php

namespace App\Form;

use App\Entity\Footer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType as SymfonyTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FooterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', SymfonyTextType::class, [
                'label' => 'Valor',
                'required' => true,
            ])
            ->add('visibility', CheckboxType::class, [
                'label' => 'Visibilidad',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Footer::class,
        ]);
    }
}
