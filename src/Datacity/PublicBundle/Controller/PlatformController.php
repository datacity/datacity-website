<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Datacity\PublicBundle\Entity\Platform;
use Datacity\PublicBundle\Form\PlatformType;
use Datacity\PublicBundle\Form\PlatformEditType;


class PlatformController extends Controller
{
    public function indexAction()
    {
    	$news = $this->getDoctrine()->getRepository("DatacityPublicBundle:Platform")->findAll();	

    	$response = $this->render('DatacityPublicBundle::platform.html.twig', array('platform' => $platform));
    	return $response;
    }

    // ADD ACTION
   public function addAction()
    {
    // On crée un objet platform
    $platform = new Platform();


    $form = $this->createForm(new PlatformType, $Platform);

    // On récupère la requête
    $request = $this->get('request');

    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      
      $form->bind($request);

      // On vérifie que les valeurs entrées sont correctes
      if ($form->isValid()) {
        // On l'enregistre notre objet $platform dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($platform);
        $em->flush();

    
    // On redirige vers la page de visualisation de la platform nouvellement créé
    return $this->redirect($this->generateUrl('datacity_public_platform'), 301);    
      }
    }

    // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('DatacityPublicBundle::addplatform.html.twig', array(
        'form' => $form->createView(),
    ));
    }

     public function removeAction($platform_id)
    {
        if ($platform_id != -1) {
            $platform = $this->getDoctrine()->getRepository("DatacityPublicBundle:Platform")->find($platform_id); 
            $name = $platform->getName();
            $em = $this->getDoctrine()->getManager();
            $em->remove($platform);
            $em->flush();

            //return "Name" . $platform_id . " deleted";
            $response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $platform_id));
            return $response;
        }
        $response = new JsonResponse(array('status' => false, 'name' => "UNKNOWN", 'id' => $platform_id));
        return $response;
    }

      public function updateAction()
    {

    $form = $this->createForm(new PlatformEditType(), $platform);

    $request = $this->getRequest();

    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On enregistre le platform
        $em = $this->getDoctrine()->getManager();
        $em->persist($platform);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Platform bien modifié');

        return $this->redirect($this->generateUrl('datacity_public_platform'), 301); 
      }
    }

    return $this->render('DatacityPublicBundle::AddPlatform.html.twig', array(
      'form'    => $form->createView(),
      'platform' => $platform
    ));
    }

}
