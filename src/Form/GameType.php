<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\WeekType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label'=>"Nom de la partie",
                'constraints' => new NotBlank(),
            ])
            ->add('image',FileType::class, [
                'label'=>'Image',
                'required' => false,
                'mapped'=>false,
            ])
            ->add('description', TextareaType::class,[
                'label'=>"Description de la partie",
                'constraints' => new NotBlank(),
                'required' => false,
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
                'required' => false
            ])
            ->add('address', TextType::class,[
                'label'=>"Adresse",
                'required' => false,
            ])
            ->add('link', TextType::class,[
                'label'=>"Lien vers la platforme de jeu",
                'required' => false,
            ])
            ->add('frequency', TextType::class,[
                'label'=>"Frequence des parties",
            ])
            ->add('nextDate', DateType::class, [
                'label'=>"Date de la prochaine partie",
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'required' => false,
            ])
            ->add('active', CheckboxType::class,[
                'label' => 'Partie active',
                'attr' => ['class' => 'flexSwitchCheckDefault'],
                'required' => false,
            ])
            ->add('open', CheckboxType::class,[
                'label' => 'Partie ouverte',
                'required' => false,
            ])
            ->add('maxPlayer', NumberType::class, [
                'label' => 'Nombre de joueurs maximum',
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
