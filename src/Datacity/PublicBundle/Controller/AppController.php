<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\PublicBundle\Entity\Application;

define("PAGINATION_LIMIT", 1);

class AppController extends Controller
{
	// Controlleur du portail applicatif. Ici nous recuperons les entites qui sont en DB pour generer le contenu
	// de notre portail applicatif. (On importe ici la liste de toutes les villes et applications).
	public function portalAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		$cities = $this->getDoctrine()->getRepository("DatacityPublicBundle:City")->findAll();	
		$applications = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application")->findAll();
		
		$dql   = "SELECT a FROM DatacityPublicBundle:Application a";
    	$query = $em->createQuery($dql);

    	$paginator  = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
        $query,
        $this->get('request')->query->get('page', 1),PAGINATION_LIMIT);

		$response = $this->render('DatacityPublicBundle::portal.html.twig', array('filter_cities' => $cities, 'applis' => $applications, 'pagination' => $pagination));
		return $response;
	}
	
	// Controlleur pour la page de detail des applications: in ID est passe en parametre a ce controlleur via la route "detail"
	// Cette ID correspond au numero dans l'URL datacity.fr/detail/1 (1 = id)
	// Ici, on recupere l'application desiree pour generer sont contenu dynamiquement depuis la page twig.
	// Si aucune aplication n'existe avec cet ID, une exception est generee.
	public function appDetailAction(Application $app)
	{		
		$response = $this->render('DatacityPublicBundle::appDetail.html.twig', array("appli" => $app));
		return $response;
	}
}
