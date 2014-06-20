<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Datacity\PublicBundle\Entity\Place;
use Datacity\PublicBundle\Form\PlaceType;
use Datacity\PublicBundle\Form\PlaceEditType;


class PlaceController extends Controller
{
    public function indexAction()
    {
    	$news = $this->getDoctrine()->getRepository("DatacityPublicBundle:Place")->findAll();	

    	$response = $this->render('DatacityPublicBundle::place.html.twig', array('place' => $place));
    	return $response;
    }

    // ADD ACTION
   public function addAction()
    {
    // On crée un objet Place
    $place = new Place();


    
    $form = $this->createForm(new PlaceType, $city);

    // On récupère la requête
    $request = $this->get('request');

    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      
      $form->bind($request);

      // On vérifie que les valeurs entrées sont correctes
      if ($form->isValid()) {
        // On l'enregistre notre objet $place dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($place);
        $em->flush();

    
    // On redirige vers la page de visualisation de la place nouvellement créé
    return $this->redirect($this->generateUrl('datacity_public_place'), 301);    
      }
    }

    // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('DatacityPublicBundle::addPlace.html.twig', array(
        'form' => $form->createView(),
    ));
    }

     public function removeAction($place_id)
    {
        if ($place_id != -1) {
            $place = $this->getDoctrine()->getRepository("DatacityPublicBundle:Place")->find($place_id); 
            $name = $place->getName();
            $em = $this->getDoctrine()->getManager();
            $em->remove($place);
            $em->flush();

            //return "Name" . $place_id . " deleted";
            $response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $place_id));
            return $response;
        }
        $response = new JsonResponse(array('status' => false, 'name' => "UNKNOWN", 'id' => $place_id));
        return $response;
    }

      public function updateAction()
    {

    $form = $this->createForm(new PlaceEditType(), $place);

    $request = $this->getRequest();

    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On enregistre la city
        $em = $this->getDoctrine()->getManager();
        $em->persist($place);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Place bien modifié');

        return $this->redirect($this->generateUrl('datacity_public_place'), 301); 
      }
    }

    return $this->render('DatacityPublicBundle::editPlace.html.twig', array(
      'form'    => $form->createView(),
      'place' => $place
    ));
    }

}
