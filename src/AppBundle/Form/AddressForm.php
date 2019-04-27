<?php

declare(strict_types=1);

namespace AppBundle\Form;

use AppBundle\Entity\Address;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('country', EntityType::class, [
                'class' => 'AppBundle\Entity\Country',
                'choice_label' => 'name',
                'placeholder' => 'Select a Country',
                'attr' => [
                    'class' => 'select-country',
                ],
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                              ->where('c.deletedAt is NULL')
                              ->orderBy('c.name', 'ASC')
                        ;
                },
            ])
            ->add('city', EntityType::class, [
                'class' => 'AppBundle\Entity\City',
                'choice_label' => 'name',
                'placeholder' => 'Select a City',
                'attr' => [
                    'class' => 'select-city',
                ],
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                              ->where('c.deletedAt is NULL')
                              ->orderBy('c.name', 'ASC')
                        ;
                },
            ])
            ->add('streetLine1', TextType::class)
            ->add('streetLine2', TextType::class, [
                'required' => false,
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
