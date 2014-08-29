<?php

namespace Datacity\PrivateBundle\Controller;

use Datacity\UserBundle\Entity\User;
use Datacity\PublicBundle\Entity\Producer;
use Datacity\PrivateBundle\Entity\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializationContext;

use \Datetime;

class ProducersController extends Controller
{
    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();
        $producers = $this->getDoctrine()->getRepository("DatacityPublicBundle:Producer")->findAll();
        $response = new JsonResponse();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"producers":' . $serializer->serialize($producers,
                            'json', SerializationContext::create()->enableMaxDepthChecks()) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
	
	public function listAction()
	{
		$em = $this->getDoctrine()->getManager();
        $producers = $this->getDoctrine()->getRepository("DatacityPublicBundle:Producer")->findAll();		
		$response = $this->render('DatacityPrivateBundle::producers.html.twig', array('producers' => $producers));
    	return $response;
	}
	
	public function removeAction(Producer $producer)
    {
        $name = $producer->getName();
        $producer_id = $producer->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($producer);
        $em->flush();

        $response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $producer_id));
        return $response;
    }
	
	public function postAction() 
	{

	$producer = new Producer();
	
	$form = $this->createFormBuilder($producer)
                 ->add('name', 'textarea')
                 ->add('slug','textarea')
                 ->add('description','textarea')
                 ->add('link', 'textarea')
				 ->add('image', new ImageType())
                 ->getForm();
				 
    $request = $this->get('request');
    if ($request->getMethod() == 'POST') {
    $form->bind($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($producer);
      //
      $em->flush();

    
    return $this->redirect($this->generateUrl('datacity_private_producers_list'), 301);    
      }
    }
	return $this->render('DatacityPrivateBundle::addProducer.html.twig', array(
            'form' => $form->createView(),
            ));
	}

}
