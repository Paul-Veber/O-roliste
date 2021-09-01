<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'e-mail *',
                'constraints' => new NotBlank(),
            ])
            ->add('username', TextType::class, [
                'label' => 'Pseudo *',
                'constraints' => new NotBlank(),
            ])
            ->add('avatar', FileType::class, [
                'label'=>'Avatar',
                'required' => false,
                'mapped'=>false,
            ])
            ->add('description', TextareaType::class, [
                'label'=>'Description',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr'=>['class'=>'btn btn-danger'],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
