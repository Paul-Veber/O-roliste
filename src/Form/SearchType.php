<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'required' => false,
                'attr' => ['class' => 'me-2']
            ])
            ->add('category', null, [
                'expanded' => false,
                'required' => false,
                'placeholder' => 'choisissez',
                'attr' => ['class' => 'form-select']
            ])
            ->add('tags', null, [
                'expanded' => true,
                'multiple' => true, 
                'required' => false,
                'choice_attr' => function($choice, $key, $value) {
                    return ['class' => 'form-check-input'];
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
