<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Datacity\PublicBundle\Entity\CoverageTerritory;
use Datacity\PublicBundle\Form\CoverageTerritoryType;
use Datacity\PublicBundle\Form\CoverageTerritoryEditType;


class coverageTerritoryController extends Controller
{
    public function indexAction()
    {
    	$news = $this->getDoctrine()->getRepository("DatacityPublicBundle:CoverageTerritory")->findAll();	

    	$response = $this->render('DatacityPublicBundle::coverageTerritory.html.twig', array('coverageTerritory' => $coverageTerritory));
    	return $response;
    }

    // ADD ACTION
   public function addAction()
    {
    // On crée un objet coverageTerritory
    $coverageTerritory = new CoverageTerritory();

    
    $form = $this->createForm(new CoverageTerrytoriType, $coverageTerritory);

    // On récupère la requête
    $request = $this->get('request');

    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      
      $form->bind($request);

      // On vérifie que les valeurs entrées sont correctes
      if ($form->isValid()) {
        // On l'enregistre notre objet $coverageTerritory dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($coverageTerritory);
        $em->flush();

    
    // On redirige vers la page de visualisation du coverageTerritory nouvellement créé
    return $this->redirect($this->generateUrl('datacity_public_coverageTerritory'), 301);    
      }
    }

    // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('DatacityPublicBundle::addCoverageTerritory.html.twig', array(
        'form' => $form->createView(),
    ));
    }

     public function removeAction($coverageTerritory_id)
    {
        if ($coverageTerritory_id != -1) {
            $coverageTerritory = $this->getDoctrine()->getRepository("DatacityPublicBundle:coverageTerritory")->find($coverageTerritory_id); 
            $name = $coverageTerritory->getName();
            $em = $this->getDoctrine()->getManager();
            $em->remove($coverageTerritory);
            $em->flush();

            //return "Name" . $coverageTerritory_id . " deleted";
            $response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $coverageTerritory_id));
            return $response;
        }
        $response = new JsonResponse(array('status' => false, 'name' => "UNKNOWN", 'id' => $coverageTerritory_id));
        return $response;
    }

      public function updateAction()
    {

    $form = $this->createForm(new CoverageTerritoryEditType(), $coverageTerritory);

    $request = $this->getRequest();

    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On enregistre le coverageTerritory
        $em = $this->getDoctrine()->getManager();
        $em->persist($coverageTerritory);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'coverageTerritory bien modifié');

        return $this->redirect($this->generateUrl('datacity_public_coverageTerritory'), 301); 
      }
    }

    return $this->render('DatacityPublicBundle::AddCoverageTerritory.html.twig', array(
      'form'    => $form->createView(),
      'coverageTerritory' => $coverageTerritory
    ));
    }

}
