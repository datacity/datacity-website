<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\PrivateBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\JsonResponse;

class TicketsController extends Controller
{
    public function indexAction()
    {
    	$tickets = $this->getDoctrine()->getRepository("DatacityPrivateBundle:Ticket")->findAll();

    	$response = $this->render('DatacityPrivateBundle::AdminTickets.html.twig', array('tickets' => $tickets));
    	return $response;
    }

    public function removeAction(Ticket $ticket)
    {
    	$title = $ticket->getTitle();
        $ticket_id = $ticket->getId();
		$ticketManager->deleteTicket($ticket);

		$this->getDoctrine()->getManager()->flush();

    	$response = new JsonResponse(array('status' => true, 'title' => $title, 'id' =>  $ticket_id));
    	return $response;
    }
}
