<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Security\Core\Security;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ReservationType extends AbstractType
{
    private Security $security;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $email = $this->security->getUser()->getEmail();
        $builder
        ->add('email', TextType::class, [
            'label' => 'Email',
            'disabled' => true,
            'data' => $email
        ])
        ->add('reservDate', DateTimeType::class, [
            'label' => 'Date de réservation',
           
        ])

            ->add('number_seat', IntegerType::class, [
                'label' => 'Nombre de couverts',
                'attr' => [
                    'min' => 1,
                    'max' => 10
                ]
            ])

            ->add('allergy', TextType::class, [
                'label' => 'Allergie',
                'required' => false
            ])
            
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary btn-sm mt-4'
                ],
                'label' => "S'inscrire"
            ])
        ;
    }

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}