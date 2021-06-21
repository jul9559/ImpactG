<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, ['label'=>'Adresse Email', 'attr'=>['class'=>'form-control']])
            ->add('roles', ChoiceType::class, ['label'=>'Rôles utilisateur', 'choices'=> [
                'Utilisateur'=> 'ROLE_USER',
                'Administrateur' => 'ROLE_ADMIN',
                'Partenaire/Organisateur' => 'ROLE_BUSINESS'
            ],
            'attr'=>['class'=>'form-control'],
            'multiple'=>true
            ])
            ->add('plainPassword', PasswordType::class, ['mapped'=>false, 'empty_data' => '','required'=>false, 'label'=>'Mot de passe','attr'=>['class'=>'form-control']])
            ->add('firstName', TextType::class, ['label'=>'Prénom', 'attr'=>['class'=>'form-control']])
            ->add('lastName', TextType::class, ['label'=>'Nom', 'attr'=>['class'=>'form-control']])
            ->add('Company', TextType::class, ['required'=>false, 'label'=>'Compagnie', 'attr'=>['class'=>'form-control']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
