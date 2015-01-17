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

    public function removeAction(User $user)
    {
    	$name = $user->getFirstname() . " " . $user->getLastname();
        $user_id = $user->getId();
    	$userManager = $this->container->get('fos_user.user_manager');
		$userManager->deleteUser($user);

		$this->getDoctrine()->getManager()->flush();

    	$response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $user_id));
    	return $response;
    }
}
