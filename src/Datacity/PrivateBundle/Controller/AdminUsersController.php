<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityRepository;

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

    public function editAction(User $user)
    {
       // $producer = new User();
    
    $form = $this->createFormBuilder($user)
                 ->add('firstname', 'textarea')
                 ->add('lastname','textarea')
                 ->add('city', 'entity', array(
                    'class' => 'DatacityPublicBundle:City',
                    'property' => 'name',
                    'multiple' => false,
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('g')
                      ->orderBy('g.name', 'ASC');
                      },
                  ))
                 ->add('email', 'textarea')
                 ->getForm();
                 
    $request = $this->get('request');
    if ($request->getMethod() == 'POST'){
    $form->bind($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      //
      $em->flush();

    
    return $this->redirect($this->generateUrl('datacity_private_adminusers'), 301);    
      }
    }
    return $this->render('DatacityPrivateBundle::editAdminUser.html.twig', array(
            'form' => $form->createView(),
            ));

    }
}
