<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class TicketAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                       ->add('email', EmailType::class, [
                'label' => 'Votre adresse e-mail',
                'attr' => ['class' => 'form-control'], 
                'constraints' => [
                    new NotBlank ([
                        'message'=> 'Veuillez saisir un e-mail', 
                     ]), 
                     // https://regexr.com/3e48o
                     new Regex([
                        'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                        'message'=> 'Mail incorrect',
                     ]), 
                ], 
                'required' => true, 
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du ticket (10 à 250 caractères)',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => '10',
                    'cols' => '250',
                ],
                'required' => true,
            ])
            ->add('categorie', ChoiceType::class, [
                'label' => 'Catégorie',
                'attr' => [  'class' => 'form-control'  ],
                'choices' => [
                    'Incident' => 'Incident',
                    'Panne' => 'Panne',
                    'Évolution' => 'Évolution',
                    'Anomalie' => 'Anomalie',
                    'Information' => 'Information',
                ],
                'required' => true,
            ])
            ->add('dateOuverture', DateTimeType::class, [ 
                'label' => 'Date Ouverture',
                'attr' => [  'class' => 'form-control'  ],
                'widget' => 'single_text',
                'disabled' => true,
                
            ])
            ->add('dateCloture', DateTimeType::class, [
                'label' => 'Date Cloture',
                'attr' => [  'class' => 'form-control'  ],
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Nouveau' => 'Nouveau',
                    'Ouvert' => 'Ouvert',
                    'Résolu' => 'Résolu',
                    'Fermé' => 'Fermé',
                ],
                'required' => true,
            ]) 
            // Par la suite il faudrait propose parmis une liste de personnes User qui a le bon role 
            ->add('responsable', TextType::class, [
                'label' => 'Responsable',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new NotBlank ([
                        'message'=> 'Veuillez saisir un nom de Responsable', 
                     ]),
                     new Length ([
                        'min' => 3,
                        'minMessage' => 'Le nom du Responsable doit contenir au moins {{ limit }} caractères', 
                        'max'=> 32,
                        'maxMessage' => 'Le nom du Responsable doit contenir au plus {{ limit }} caractères', 
                     ]), 
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
