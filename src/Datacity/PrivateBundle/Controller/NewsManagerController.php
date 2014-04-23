<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\UserBundle\Entity\User;
use Datacity\PublicBundle\Entity\News;
use Symfony\Component\HttpFoundation\JsonResponse;


class NewsManagerController extends Controller
{
    public function indexAction()
    {
    	$news = $this->getDoctrine()->getRepository("DatacityPublicBundle:News")->findAll();	

    	$response = $this->render('DatacityPrivateBundle::newsManager.html.twig', array('news' => $news));
    	return $response;
    }

    // ADD ACTION
   public function addAction()
    {
    // On crée un objet Article
    $news = new News();
    
    // Récupère l'utilisateur courant
    $news->setUser($this->get('security.context')->getToken()->getUser());
    // On crée le FormBuilder grâce à la méthode du contrôleur
    $formBuilder = $this->createFormBuilder($news);
    // On ajoute les champs de l'entité que l'on veut à notre formulaire
    $formBuilder
        ->add('title', 'text')
        ->add('message', 'textarea')
        ->add('img', 'text');
    // À partir du formBuilder, on génère le formulaire
    $form = $formBuilder->getForm();
    // On récupère la requête
    $request = $this->get('request');
    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      // On fait le lien Requête <-> Formulaire
      // À partir de maintenant, la variable $article contient les valeurs entrées dans le formulaire par le visiteur
      $form->bind($request);

      // On vérifie que les valeurs entrées sont correctes
      if ($form->isValid()) {
        // On enregistre l'article dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($news);
        $em->flush();

        // On redirige vers la page de visualisation de l'article nouvellement créé
        return $this->redirect($this->generateUrl('datacity_private_newsmanager'), 301);
        
      }
    }

    // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('DatacityPrivateBundle::addNews.html.twig', array(
        'form' => $form->createView(),
    ));
    }

}
