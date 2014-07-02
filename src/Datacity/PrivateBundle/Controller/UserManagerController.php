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
    	$point = $user->getPoint();
    	$about = $user->getAbout();
    	$joinDate = $user->getJoinDate();
    	$city = $user->getCity();
    	$website = $user->getWebsiteUrl();
    	$response = new JsonResponse(array('firstName' => $firstName, 'lastName' => $lastName, 
    		'point' => $point, 'about' => $about, 'website' => $website, 'joinDate' => $joinDate, 'city' => $city));
    	return $response;
    }

    public function postAction()
    {
    	//Enregistrer l'utilisateur en bdd et renvoyer une reponse
    	$response = new JsonResponse(array('action' => 'success'));
        return $response;
    }
}