<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\PublicBundle\Entity\Producer;

define("PAGINATION_LIMIT", 2);

class ProducerController extends Controller
{
	public function listAction()
	{
		$em = $this->getDoctrine()->getManager();
		$producers = $this->getDoctrine()->getRepository("DatacityPublicBundle:Producer")->findAll();
		
		$dql   = "SELECT a FROM DatacityPublicBundle:Producer a";
    	$query = $em->createQuery($dql);

    	$paginator  = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
        $query,
        $this->get('request')->query->get('page', 1),PAGINATION_LIMIT);

		$response = $this->render('DatacityPublicBundle::producerList.html.twig', array('producers' => $producers, 'pagination' => $pagination));
		return $response;
	}
	
	public function showAction(Producer $prod)
	{		
		$response = $this->render('DatacityPublicBundle::producerDetail.html.twig', array("producer" => $prod));
		return $response;
	}
}
