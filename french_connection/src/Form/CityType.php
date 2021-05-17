<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextareaType::class, [
                'label' => "Ville",
                'required' => true,
            ])
            //->add('cityCode')
            ->add('longitude', null, [
                'constraints' => new NotBlank(),
            ])
            ->add('latitude', null, [
                'constraints' => new NotBlank(),
            ])
            //->add('createdAt')
            //->add('updatedAt')
            ->add('country')
            //->add('travels')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => City::class,
        ]);
    }
}
