<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketAdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TicketAdminController extends AbstractController
{
    // #[Route('/ticket/admin', name: 'app_ticket_admin')]
    // public function ticket_admin(): Response
    // {
    //     return $this->render('ticket_admin/index.html.twig', [
    //         'controller_name' => 'TicketAdminController',
    //     ]);
    // }
    // Liste des tickets
    #[Route('/admin/ticket', name: 'admin_ticket_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tickets = $entityManager->getRepository(Ticket::class)->findAll();

        return $this->render('ticket_admin/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }


    // Créer un nouveau ticket on met une nouvelle page comme le client avec des champs en plus 
    #[Route('/nouveau.html.twig', name: 'admin_ticket_nouveau', methods: ['GET', 'POST'])]
    public function nouveau(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketAdminType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('admin_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket_admin/nouveau.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    // Editer un ticket existant
    #[Route('/{id}/edit', name: 'admin_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketAdminType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket_admin/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

}
