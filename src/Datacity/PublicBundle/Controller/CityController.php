<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Datacity\PublicBundle\Entity\City;


class CityController extends Controller
{
    public function indexAction()
    {
    	$news = $this->getDoctrine()->getRepository("DatacityPublicBundle:City")->findAll();	

    	$response = $this->render('DatacityPublicBundle::city.html.twig', array('city' => $city));
    	return $response;
    }

    // ADD ACTION
   public function addAction()
    {
    // On crée un objet City
    $city = new City();


    
    $form = $this->createFormBuilder($city)
                 ->add('name',        'name')
                 ->getForm();

    // On récupère la requête
    $request = $this->get('request');

    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      
      $form->bind($request);

      // On vérifie que les valeurs entrées sont correctes
      if ($form->isValid()) {
        // On l'enregistre notre objet $city dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($city);
        $em->flush();

    
    // On redirige vers la page de visualisation de la city nouvellement créé
    return $this->redirect($this->generateUrl('datacity_public_city'), 301);    
      }
    }

    // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('DatacityPublicBundle::addCity.html.twig', array(
        'form' => $form->createView(),
    ));
    }

     public function removeAction($city_id)
    {
        if ($city_id != -1) {
            $city = $this->getDoctrine()->getRepository("DatacityPublicBundle:City")->find($city_id); 
            $name = $city->getName();
            $em = $this->getDoctrine()->getManager();
            $em->remove($city);
            $em->flush();

            //return "Name" . $city_id . " deleted";
            $response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $city_id));
            return $response;
        }
        $response = new JsonResponse(array('status' => false, 'name' => "UNKNOWN", 'id' => $city_id));
        return $response;
    }

      public function updateAction()
    {
    }

}
