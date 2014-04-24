<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\UserBundle\Entity\User;
use Datacity\PublicBundle\Entity\News;
use Datacity\PrivateBundle\Entity\NewsType;
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

    $form = $this->createForm(new NewsType, $news);

    $request = $this->get('request');
    if ($request->getMethod() == 'POST') {
    $form->bind($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      //$em->persist($news->getImage());
      $em->persist($news);
      //
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

     public function removeAction($news_id)
    {
        if ($news_id != -1) {
            $news = $this->getDoctrine()->getRepository("DatacityPublicBundle:News")->find($news_id); 
            $title = $news->getTitle();
            $em = $this->getDoctrine()->getManager();
            $em->remove($news);
            $em->flush();

            //return "Title" . $news_id . " deleted";
            $response = new JsonResponse(array('status' => true, 'title' => $title, 'id' => $news_id));
            return $response;
        }
        $response = new JsonResponse(array('status' => false, 'title' => "UNKNOWN", 'id' => $news_id));
        return $response;
    }

}
