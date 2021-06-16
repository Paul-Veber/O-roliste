<?php

namespace App\Form;

use App\Entity\Game;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\WeekType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditGameType extends AbstractType
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
        ])
        ->add('description', TextType::class,[
            'label'=>"Description de la partie",
            'constraints' => new NotBlank(),
            'required' => false,
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
            'required' => false,
        ])
        ->add('nextDate', WeekType::class, [
            'label'=>"Date de la prochaine partie",
            'placeholder' => 'Select a value',
            'required' => false,
        ])
        ->add('active', CheckboxType::class,[
            'label' => 'Partie active',
            'required' => false,
        ])
        ->add('open', CheckboxType::class,[
            'label' => 'Partie ouverte',
            'required' => false,
        ])
        ->add('maxPlayer', NumberType::class, [
            'label' => 'Nombre de joueurs maximum',
        ])
        //->add('createdAt')
        //->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
