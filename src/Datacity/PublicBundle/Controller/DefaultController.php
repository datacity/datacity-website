<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	public function homeAction()
	{
		$response = $this->render('DatacityPublicBundle::home.html.twig');
		return $response;
	}
	public function portalAction()
	{
		$response = $this->render('DatacityPublicBundle::portal.html.twig');
		return $response;
	}
	public function documentationAction()
	{
		$response = $this->render('DatacityPublicBundle::documentation.html.twig');
		return $response;
	}
	public function dataviewAction()
	{
		$response = $this->render('DatacityPublicBundle::dataview.html.twig');
		return $response;
	}
}
