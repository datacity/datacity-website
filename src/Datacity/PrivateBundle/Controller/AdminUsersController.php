<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminUsersController extends Controller
{
    public function indexAction()
    {
    	$users = $this->getDoctrine()->getRepository("DatacityUserBundle:User")->findAll();

    	$response = $this->render('DatacityPrivateBundle::adminUsers.html.twig', array('users' => $users));
    	return $response;
    }

    public function removeAction(User $user)
    {
    	$name = $user->getFirstname() . " " . $user->getLastname();
        $user_id = $user->getId();
    	$userManager = $this->container->get('fos_user.user_manager');
		$userManager->deleteUser($user);

		$this->getDoctrine()->getManager()->flush();

    	$response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $user_id));
    	return $response;
    }
}
