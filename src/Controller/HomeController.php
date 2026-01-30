<?php
// Note pour Eval 
// ===============================
// Execution des commandes suivante 
//
// 1. Installation twig 
// composer require symfony/twig-bundle 
//
// 2. Creation du controleur du fichier de test aussi 
// php bin/console make:controller HomeController 
//
// 3. Creation d'une route app_login pour les tests 
// et amélioration index en controlant le retour du formulaire 
// Pour le moment sans base de donnee 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

// Declaration librairie formulaire TicketType
use App\Form\TicketType;
use App\Entity\Ticket;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
                // Si le formulaire est valide, on enregistre le ticket
                $ticket->setStatut('Nouveau');
                $ticket->setResponsable('Non assigné');

                $entityManager->persist($ticket);
                $entityManager->flush();
                // Affichage d'un message success
                $this->addFlash('success', 'Ticket créé avec succès !');
                return $this->redirectToRoute('app_home'); 
        }
           

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
 
}
