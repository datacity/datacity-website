<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Datacity\PublicBundle\Entity\Tag;
use Datacity\PublicBundle\Form\TagType;
use Datacity\PublicBundle\Form\TagEditType;




class TagController extends Controller
{
    public function indexAction()
    {
    	$news = $this->getDoctrine()->getRepository("DatacityPublicBundle:Tag")->findAll();	

    	$response = $this->render('DatacityPublicBundle::tag.html.twig', array('tag' => $tag));
    	return $response;
    }

    // ADD ACTION
   public function addAction()
    {
    // On crée un objet Tag
    $tag = new Tag();


    $form = $this->createForm(new TagType, $tag);

    // On récupère la requête
    $request = $this->get('request');

    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      
      $form->bind($request);

      // On vérifie que les valeurs entrées sont correctes
      if ($form->isValid()) {
        // On l'enregistre notre objet $tag dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($tag);
        $em->flush();

    
    // On redirige vers la page de visualisation de la tag nouvellement créé
    return $this->redirect($this->generateUrl('datacity_public_tag'), 301);    
      }
    }

    // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('DatacityPublicBundle::addTag.html.twig', array(
        'form' => $form->createView(),
    ));
    }

     public function removeAction($tag_id)
    {
        if ($tag_id != -1) {
            $tag = $this->getDoctrine()->getRepository("DatacityPublicBundle:Tag")->find($tag_id); 
            $name = $tag->getName();
            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush();

            //return "Name" . $tag_id . " deleted";
            $response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $tag_id));
            return $response;
        }
        $response = new JsonResponse(array('status' => false, 'name' => "UNKNOWN", 'id' => $tag_id));
        return $response;
    }

      public function updateAction()
    {
        $form = $this->createForm(new TagEditType(), $tag);

    $request = $this->getRequest();

    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On enregistre le tag
        $em = $this->getDoctrine()->getManager();
        $em->persist($tag);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Tag bien modifié');

        return $this->redirect($this->generateUrl('datacity_public_tag'), 301); 
      }
    }

    return $this->render('DatacityPublicBundle::AddTag.html.twig', array(
      'form'    => $form->createView(),
      'tag' => $tag
    ));
    }

}
