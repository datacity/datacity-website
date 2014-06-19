<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileManagerController extends Controller
{
    public function indexAction()
    {
    	$user = $this->get('security.context')->getToken()->getUser();

    	$response = $this->render('DatacityPrivateBundle::profileManager.html.twig', array('user' => $user));
    	return $response;
    }


}
