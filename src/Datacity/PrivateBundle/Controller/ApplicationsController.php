<?php

namespace Datacity\PrivateBundle\Controller;

use Datacity\UserBundle\Entity\User;
use Datacity\PublicBundle\Entity\Image;
use Doctrine\ORM\EntityRepository;
use Datacity\PublicBundle\Entity\Application;
use Datacity\PrivateBundle\Entity\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializationContext;

use \Datetime;

class ApplicationsController extends Controller
{
    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();
        $applications = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application")->findAll();
        $response = new JsonResponse();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"applications":' . $serializer->serialize($applications,
                            'json', SerializationContext::create()->enableMaxDepthChecks()) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
	
	public function listAction()
	{
		$em = $this->getDoctrine()->getManager();
        $applications = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application")->findAll();		
		$response = $this->render('DatacityPrivateBundle::applications.html.twig', array('applications' => $applications));
    	return $response;
	}
	
	public function removeAction(Application $application)
    {
        $name = $application->getName();
        $application_id = $application->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($application);
        $em->flush();

        $response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $application_id));
        return $response;
    }
	

	public function postAction() 
	{

	$application = new Application();
	
  $application->setDownloaded(0);

	$form = $this->createFormBuilder($application)
                 ->add('name', 'textarea')
                 ->add('description','textarea')
                 ->add('city', 'entity', array(
                    'class' => 'DatacityPublicBundle:City',
                    'property' => 'name',
                    'multiple' => false,
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('g')
                      ->orderBy('g.name', 'ASC');
                      },
                  ))
				         ->add("images", "collection", array("type" => new ImageType()))
                 ->add('categories', 'entity', array(
                    'class' => 'DatacityPublicBundle:Category',
                    'property' => 'name',
                    'multiple' => true,
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('g')
                      ->orderBy('g.name', 'ASC');
                      },
                    ))
                 ->add('platforms', 'entity', array(
                    'class' => 'DatacityPublicBundle:Platform',
                    'property' => 'name',
                    'multiple' => true,
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('g')
                      ->orderBy('g.name', 'ASC');
                      },
                    ))
                ->getForm();
				 
    $request = $this->get('request');
    if ($request->getMethod() == 'POST'){
    $form->bind($request);

    if ($form->isValid()) {
      $application->setUrl($application->getName());
      $em = $this->getDoctrine()->getManager();
      $em->persist($application);
      //
      $em->flush();

    
    return $this->redirect($this->generateUrl('datacity_private_applications_list'), 301);    
      }
    }
	return $this->render('DatacityPrivateBundle::addApplications.html.twig', array(
            'form' => $form->createView(),
            ));
	}

}
