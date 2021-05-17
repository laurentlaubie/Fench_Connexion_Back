<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => new NotBlank(),
                'required' => true,
                'trim' =>true,
            ])
            //->add('roles')
            ->add('password', PasswordType::class, [
                'constraints' => new NotBlank(),
                'mapped' => false,
            ])
            ->add('confirmedPassword', null, [
                'mapped' => false,
                'required' => true,
            ])
            /*->add('username', null, [
                'constraints' => new NotBlank(),
                ])*/
            //->add('avatar')
            ->add('biography', TextareaType::class, [
                'label' => "biographie",
            ])
            /*->add('shortDescription', TextareaType::class, [
                'label' => "description",
                ])*/
            //->add('comment')
            //->add('helper')
            //->add('status')
            ->add('firstname', TextType::class, [
                'constraints' => new NotBlank(),
            ])
            ->add('lastname', TextType::class, [
                'constraints' => new NotBlank(),
            ])
            ->add('phoneNumber')
            ->add('nickname', TextType::class, [
                'constraints' => new NotBlank(),
            ])
            //->add('createdAt')
            //->add('updatedAt')
            ->add('hobbies', null, [])
            ->add('services', null, [])
            ->add('userAdress', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'prototype' => true,
                'mapped' => false
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


