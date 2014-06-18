<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Datacity\PublicBundle\Entity\Application;


class ApplicationController extends Controller
{
    public function indexAction()
    {
    	$news = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application")->findAll();	

    	$response = $this->render('DatacityPublicBundle::application.html.twig', array('application' => $application));
    	return $response;
    }

    // ADD ACTION
   public function addAction()
    {
    // On crée un objet application
    $application = new Application();


    
    $form = $this->createFormBuilder($application)
                 ->add('name', 'name')
                 ->add('url', 'url')
                 ->add('downloaded','downloaded')
                 ->add('description', 'description')
                 ->add('rating', 'rating')
                 ->add('image', 'image')
                 ->add('city', 'city')
                 ->add('platform', 'platform')
                 ->add('category', 'category')
                 ->add('user', 'user')
                 ->getForm();

    // On récupère la requête
    $request = $this->get('request');

    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      
      $form->bind($request);

      // On vérifie que les valeurs entrées sont correctes
      if ($form->isValid()) {
        // On l'enregistre notre objet $application dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($application);
        $em->flush();

    
    // On redirige vers la page de visualisation de l'application nouvellement créé
    return $this->redirect($this->generateUrl('datacity_public_application'), 301);    
      }
    }

    // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('DatacityPublicBundle::addapplication.html.twig', array(
        'form' => $form->createView(),
    ));
    }

     public function removeAction($application_id)
    {
        if ($application_id != -1) {
            $application = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application")->find($application_id); 
            $name = $application->getName();
            $em = $this->getDoctrine()->getManager();
            $em->remove($application);
            $em->flush();

            //return "Name" . $application_id . " deleted";
            $response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $application_id));
            return $response;
        }
        $response = new JsonResponse(array('status' => false, 'name' => "UNKNOWN", 'id' => $application_id));
        return $response;
    }

      public function updateAction()
    {
    }

}
