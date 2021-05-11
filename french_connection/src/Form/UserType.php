<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            //->add('roles')
            ->add('password')
            ->add('confirmedPassword', null, [
                'mapped' => false,
                'required' => true,
            ])
            //->add('username')
            //->add('avatar')
            //->add('biography')
            //->add('shortDescription')
            //->add('comment')
            //->add('helper')
            //->add('status')
            //->add('createdAt')
            //->add('updatedAt')
            //->add('hobbies')
            //->add('services')
            //->add('cities')
            ->add('firstname')
            ->add('lastname')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
