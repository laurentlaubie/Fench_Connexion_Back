<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            //->add('roles')
            ->add('password', null, [
                'mapped' => false,
            ])
            ->add('confirmedPassword', null, [
                'mapped' => false,
            ])
            //->add('username')
            //->add('avatar')
            ->add('biography')
            //->add('shortDescription')
            //->add('comment')
            //->add('helper')
            //->add('status')
            ->add('firstname')
            ->add('lastname')
            ->add('phoneNumber')
            ->add('nickname')
            //->add('createdAt')
            //->add('updatedAt')
            //->add('hobbies')
            //->add('services')
            ->add('cities', TextType::class, [
                'mapped' => false,
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
