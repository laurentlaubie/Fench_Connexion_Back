<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => new NotBlank(),
                'required' => true,
                'trim' => true,
            ])
            //->add('roles')
            ->add('password', PasswordType::class, [
                'constraints' => new NotBlank(),
            ])
            ->add('confirmedPassword', null, [
                'mapped' => false,
                'required' => true,
            ])
            /*->add('username', null, [
                'constraints' => new NotBlank(),
            ])*/
            /*->add('avatar', FileType::class, [
                'mapped' => false,
            ])
            /*->add('biography', TextareaType::class, [
                'label' => "biographie",
            ])*/
            /*->add('shortDescription', TextareaType::class, [
                'label' => "description",
            ])*/
            //->add('comment')
            //->add('helper')
            //->add('status')
            //->add('createdAt')
            //->add('updatedAt')
            //->add('hobbies')
            //->add('services')
            //->add('cities')
            ->add('firstname', TextType::class, [
                'constraints' => new NotBlank(),
            ])
            ->add('lastname', TextType::class, [
                'constraints' => new NotBlank(),
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

