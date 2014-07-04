<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\PublicBundle\Entity\Producer;

class ProducerController extends Controller
{
	public function listAction()
	{
		$em = $this->getDoctrine()->getManager();
		$producers = $this->getDoctrine()->getRepository("DatacityPublicBundle:Producer")->findAll();
		
		$response = $this->render('DatacityPublicBundle::producerList.html.twig', array('producers' => $producers));
		return $response;
	}
	
	public function showAction(Producer $prod)
	{		
		$response = $this->render('DatacityPublicBundle::producerDetail.html.twig', array("producer" => $prod));
		return $response;
	}
}
