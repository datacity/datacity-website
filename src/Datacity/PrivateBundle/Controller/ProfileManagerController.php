<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileManagerController extends Controller
{
    public function indexAction()
    {
    	$response = $this->render('DatacityPrivateBundle::profileManager.html.twig');
    	return $response;
    }
}
