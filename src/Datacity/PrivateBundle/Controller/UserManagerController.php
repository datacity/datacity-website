<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserManagerController extends Controller
{
    public function getAction()
    {
    	$user = $this->get('security.context')->getToken()->getUser();
    	$firstName = $user->getFirstName();
    	$lastName = $user->getLastName();
    	$response = new JsonResponse(array('firstName' => $firstName, 'lastName' => $lastName));
    	return $response;
    }
}