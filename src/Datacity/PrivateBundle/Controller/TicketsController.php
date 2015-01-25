<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\PrivateBundle\Entity\Ticket;
use Datacity\PrivateBundle\Entity\ReplyTicket;
use Symfony\Component\HttpFoundation\JsonResponse;

class TicketsController extends Controller
{
    public function indexAction()
    {
    	$tickets = $this->getDoctrine()->getRepository("DatacityPrivateBundle:Ticket")->findAll();

    	$response = $this->render('DatacityPrivateBundle::AdminTickets.html.twig', array('tickets' => $tickets));
    	return $response;
    }

    public function TicketDetailAdminAction(Ticket $ticket)
    {
        return $this->render('DatacityPrivateBundle::TicketDetailAdmin.html.twig', array("ticket" => $ticket));
    }

    public function postAction(Ticket $ticket) 
    {

    $replyTicket = new ReplyTicket();
    
    $form = $this->createFormBuilder($replyTicket)
                 ->add('message','textarea')
                 ->getForm();
                 
    $request = $this->get('request');
    if ($request->getMethod() == 'POST'){
    $form->bind($request);

    if ($form->isValid()) {
      $replyTicket->setMessage($replyTicket->getMessage());
      $replyTicket->setTicket($ticket);
      $em = $this->getDoctrine()->getManager();
      $em->persist($replyTicket);
      $em->flush();

    
    return $this->redirect($this->generateUrl('datacity_public_ticket_detail_admin', array('slug' => $ticket->getSlug())));    
      }
    }
    return $this->render('DatacityPrivateBundle::TicketDetailAdmin.html.twig', array(
            'form' => $form->createView(),
            ));
    }

    public function removeAction(Ticket $ticket)
    {
    	$title = $ticket->getTitle();
        $ticket_id = $ticket->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($ticket);
        $em->flush();
        

    	$response = new JsonResponse(array('status' => true, 'title' => $title, 'id' =>  $ticket_id));
    	return $response;
    }
}
