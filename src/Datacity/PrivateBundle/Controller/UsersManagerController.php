<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;


class UsersManagerController extends Controller
{
    public function indexAction()
    {
    	$users = $this->getDoctrine()->getRepository("DatacityUserBundle:User")->findAll();	

    	$response = $this->render('DatacityPrivateBundle::usersManager.html.twig', array('users' => $users));
    	return $response;
    }


    public function removeAction($user_id)
    {
    	if ($user_id != -1) {
	    	$user = $this->getDoctrine()->getRepository("DatacityUserBundle:User")->find($user_id);	
	    	$name = $user->getFirstname() . " " . $user->getLastname();
	    	$userManager = $this->container->get('fos_user.user_manager');
			$userManager->deleteUser($user);

			$this->getDoctrine()->getManager()->flush();

	    	//return "User " . $user_id . " deleted";
	    	$response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $user_id));
	    	return $response;
    	}
	    $response = new JsonResponse(array('status' => false, 'name' => "UNKNOWN", 'id' => $user_id));
	    return $response;
    }
}
