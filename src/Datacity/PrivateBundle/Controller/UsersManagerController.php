<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersManagerController extends Controller
{
    public function indexAction()
    {
    	$response = $this->render('DatacityPrivateBundle::usersManager.html.twig');
    	return $response;
    }
}
