<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\PublicBundle\Entity\News;

define("PAGINATION_LIMIT", 2);

class NewsController extends Controller
{

	// Controller de la page News
	// Dans ce controller nous récupérons également l'ensemble des catégories car nous avons besoins de les réafficher sur la page de news.
	public function newsAction()
	{
		
		$em = $this->getDoctrine()->getManager();
		
		
		// Récupération des news qui sont en base
		$news = $this->getDoctrine()->getRepository("DatacityPublicBundle:News");
		$news = $news->findAll();
		
		$dql   = "SELECT a FROM DatacityPublicBundle:News a";
    	$query = $em->createQuery($dql);

    	$paginator  = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
        $query,
        $this->get('request')->query->get('page', 1), PAGINATION_LIMIT);

		//Redirection vers la page news en envoyant le tableau de news et de categories initialisé précédement.
		$response = $this->render('DatacityPublicBundle::news.html.twig', array('news' => $news, 'pagination' => $pagination));
		return $response;
	}
	
	public function newsDetailAction(News $news)
	{
		return $this->render('DatacityPublicBundle::newsDetail.html.twig', array("news" => $news));
	}
}
