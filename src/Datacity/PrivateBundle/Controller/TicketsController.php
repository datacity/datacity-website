<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\PrivateBundle\Entity\Ticket;
use Datacity\PrivateBundle\Entity\ReplyTicket;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;

class TicketsController extends Controller
{
    public function indexAction()
    {
    	$tickets = $this->getDoctrine()->getRepository("DatacityPrivateBundle:Ticket")->findAll();

    	$response = $this->render('DatacityPrivateBundle::AdminTickets.html.twig', array('tickets' => $tickets));
    	return $response;
    }

    public function detailAction(Request $request, Ticket $ticket)
    {
        $replyTicket = new ReplyTicket();

        $form = $this->createFormBuilder($replyTicket)
                     ->add('message','textarea')
                     ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            // Récupère l'utilisateur courant
            $user = $this->getUser();
            $ticket->setAssignedUser($user);
            $ticket->setStatut($request->request->get('replyandclose') ? Ticket::CLOSE : Ticket::ASSIGNED);
            $replyTicket->setMessage($replyTicket->getMessage());
            $replyTicket->setTicket($ticket);
            $em = $this->getDoctrine()->getManager();
            $em->persist($replyTicket);
            $em->flush();


            return $this->redirect($this->generateUrl('datacity_private_tickets_detail_admin', array('slug' => $ticket->getSlug())));
          }
        return $this->render('DatacityPrivateBundle::TicketDetailAdmin.html.twig', array(
                'form' => $form->createView(), 'ticket' => $ticket
                ));
    }


    public function getUserTicketsAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $results = $em->createQueryBuilder()->select('t')
                  ->from('DatacityPrivateBundle:Ticket', 't')
                  ->where('t.author = ?1')
                  ->setParameter(1, $user->getId())
                  ->getQuery()->getResult();
        $response = new Response();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"results":' . $serializer->serialize($results,
                            'json', SerializationContext::create()->setGroups(array('userTickets'))) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getUserTicketAction(Ticket $ticket)
    {
        $response = new Response();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"results":' . $serializer->serialize($ticket,
                            'json', SerializationContext::create()->setGroups(array('userTickets'))) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function replyUserTicketAction(Request $request, Ticket $ticket)
    {
        $content = $request->getContent();
        if (!empty($content)) {
            $params = json_decode($content);
            if (!isset($params->message))
                return $this->thereIsAProblemHere('Missing parameters');
            $replyticket = new ReplyTicket();

            $replyticket->setMessage($params->message);
            $replyticket->setTicket($ticket);

            $em = $this->getDoctrine()->getManager();
            $em->persist($replyticket);
            $em->flush();
            $response = new JsonResponse(array('action' => 'success'));
        } else {
            return $this->thereIsAProblemHere();
        }
        return $response;
    }

    private function thereIsAProblemHere($error = 'failure') {
        return new JsonResponse(array('error' => $error), 400);
    }

    public function createUserTicketsAction(Request $request)
    {
        $content = $request->getContent();
        if (!empty($content)) {
            $params = json_decode($content);
            if (!isset($params->title) || !isset($params->message))
                return $this->thereIsAProblemHere('Missing parameters');
            $ticket = new Ticket();
            $ticket->setTitle($params->title);
            $ticket->setMessage($params->message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();
            $response = new JsonResponse(array('action' => 'success'));
        } else {
            return $this->thereIsAProblemHere();
        }
        return $response;
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
