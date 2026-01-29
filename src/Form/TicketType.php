<?php
// Note pour Eval 
// ===============================
// 1. Installation librairie Form pour les formulaires
// composer require symfony/form
//
// 2. Creation du entity Ticket 
// symfony console make:entity Ticket 
//
// 3. Creation du formulaire TicketType
// symfony console make:form TicketType
// >Ticket
//
// 4. Creation du formulaire et des controles 
// 


namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// Pour les differents type (EmailType: mail ,TextareaType: text area, ChoiceType Combobox  )
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank; 
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Les champs du formulaire 
        // Le client ne pourra renseigner que : 
        //      son adresse e-mail : (EmailType) email
        //      la description : (TextareaType) description du problème 
        //      la catégorie  :(ChoiceType)  liste déroulante et contenir les valeurs suivantes : « Incident », « Panne », « Évolution », « Anomalie », « Information »   
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
            ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
