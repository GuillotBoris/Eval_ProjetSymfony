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
        // Entity ou class 
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        // Si la validation du formulaire est bonne on insere en base de donnees 
    if ($form->isSubmitted() && $form->isValid()) {
        // Pour le moment aucune connection avec la base de donnée 
        /*  
        $entityManager->persist($ticket);
        $entityManager->flush();
        // Rediriger ou afficher un message de succès
        $this->addFlash('success', 'Ticket créé avec succès !');
        */
        return $this->redirectToRoute('app_login');
    }



        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Pour les tests simple supprimer ensuite
    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return new Response('<h1>Page de login en cours de développement</h1>');
    }
}
