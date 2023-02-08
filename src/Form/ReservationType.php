<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $email = $this->security->getUser()->getEmail();
        $builder
        ->add('user', TextType::class, [
            'label' => 'Email',
            'disabled' => true,
            'data' => $email
            ])

        ->add('nb_covers', ChoiceType::class, [
            // 'attr' => [
            //     'class' => 'form-control'
            // ],
            'label' => 'Nombre de couverts',
            'label_attr' => [
                // 'class' => 'form-check',
            ],
            'constraints' => [
                new NotBlank()
            ],
            'choices' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6,
            ],
            // "expanded" => true,
        ])
        ->add('planning', DateType::class, [
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'Date de réservation',
            'label_attr' => [
                'class' => 'form-label mt-4',
            ],
            'constraints' => [
                new NotNull(),
            ],
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            
        ])
        ->add('hours', ChoiceType::class, [
                'label' => "Choisissez une heure",
                'placeholder' => 'Choisissez une heure',
                'row_attr' => [
                    //  'class' => 'btn',
                ],
                'choices' =>[
                '11h00' => '11h00',
                '11h15' => '11h15',
                '11h30' => '11h30',
                '11h45' => '11h45',
                '12h00' => '12h00',
                '12h15' => '12h15',
                '12h30' => '12h30',
                '12h45' => '12h45',
                '13h00' => '13h00',
                '13h15' => '13h15',
                '13h30' => '13h30',
                '13h45' => '13h45',
                '14h00' => '14h00',
                '-',
                '18h00' => '18h00',
                '18h15' => '18h15',
                '18h30' => '18h30',
                '18h45' => '18h45',
                '19h00' => '19h00',
                '19h15' => '19h15',
                '19h30' => '19h30',
                '19h45' => '19h45',
                '20h00' => '20h00',
                '20h15' => '20h15',
                '20h30' => '20h30',
                '20h45' => '20h45',
                '21h00' => '21h00',
                '21h15' => '21h15',
                '21h30' => '21h30',
                '21h45' => '21h45',
                '22h00' => '22h00',
            
            ],
                

            ])
        
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => "Réserver"
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
