<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
 

final class TicketUserController extends AbstractController
{
    #[Route('/user/ticket', name: 'app_ticket_user', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tickets = $entityManager->getRepository(Ticket::class)->findAll();

        return $this->render('ticket_user/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }
    //  nouveau ticket user on met une nouvelle page comme le client avec des champs en plus 
    #[Route('/user/ticket/nouveau', name: 'user_ticket_nouveau', methods: ['GET', 'POST'])]
    public function nouveau(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketUserType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ticket);
            $entityManager->flush();
            // Redirection 
            return $this->redirectToRoute('app_ticket_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket_user/nouveau.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    // Editer un ticket existant on utilise {id} qui sera le numero dans la bd
    #[Route('/user/{id}/edit', name: 'user_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketuserType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            // Redirection 
            return $this->redirectToRoute('app_ticket_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket_user/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }
}
