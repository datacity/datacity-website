<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Datacity\PublicBundle\Entity\License;


class LicenseController extends Controller
{
    public function indexAction()
    {
    	$news = $this->getDoctrine()->getRepository("DatacityPublicBundle:License")->findAll();	

    	$response = $this->render('DatacityPublicBundle::license.html.twig', array('license' => $license));
    	return $response;
    }

    // ADD ACTION
   public function addAction()
    {
    // On crée un objet License
    $license = new License();


    
    $form = $this->createFormBuilder($license)
                 ->add('name',        'name')
                 ->add('description',  'description')
                 ->add('link',     'link')
                 ->getForm();

    // On récupère la requête
    $request = $this->get('request');

    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      
      $form->bind($request);

      // On vérifie que les valeurs entrées sont correctes
      if ($form->isValid()) {
        // On l'enregistre notre objet $license dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($license);
        $em->flush();

    
    // On redirige vers la page de visualisation de la license nouvellement créé
    return $this->redirect($this->generateUrl('datacity_public_license'), 301);    
      }
    }

    // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('DatacityPublicBundle::addLicense.html.twig', array(
        'form' => $form->createView(),
    ));
    }

     public function removeAction($license_id)
    {
        if ($license_id != -1) {
            $license = $this->getDoctrine()->getRepository("DatacityPublicBundle:License")->find($license_id); 
            $name = $license->getName();
            $em = $this->getDoctrine()->getManager();
            $em->remove($license);
            $em->flush();

            //return "Name" . $license_id . " deleted";
            $response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $license_id));
            return $response;
        }
        $response = new JsonResponse(array('status' => false, 'name' => "UNKNOWN", 'id' => $license_id));
        return $response;
    }

      public function updateAction()
    {
    }

}
