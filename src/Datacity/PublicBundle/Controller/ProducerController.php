<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\PublicBundle\Entity\Producer;

class ProducerController extends Controller
{
	const PAGINATION_LIMIT = 2;
	public function listAction()
	{
		$em = $this->getDoctrine()->getManager();

		$dql   = "SELECT a FROM DatacityPublicBundle:Producer a";
    	$query = $em->createQuery($dql);

    	$paginator  = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
        $query,
        $this->get('request')->query->get('page', 1), self::PAGINATION_LIMIT);

		$response = $this->render('DatacityPublicBundle::producerList.html.twig', array('pagination' => $pagination));
		return $response;
	}

	public function showAction(Producer $prod)
	{
		$response = $this->render('DatacityPublicBundle::producerDetail.html.twig', array("producer" => $prod));
		return $response;
	}
}
