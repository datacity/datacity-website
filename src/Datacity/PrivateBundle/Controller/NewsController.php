<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\UserBundle\Entity\User;
use Datacity\PublicBundle\Entity\News;
use Datacity\PrivateBundle\Entity\ImageType;
use Datacity\PrivateBundle\Entity\NewsType;
use Symfony\Component\HttpFoundation\JsonResponse;


class NewsController extends Controller
{
    public function indexAction()
    {
    	$news = $this->getDoctrine()->getRepository("DatacityPublicBundle:News")->findAll();

    	$response = $this->render('DatacityPrivateBundle::news.html.twig', array('news' => $news));
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
        return $this->redirect($this->generateUrl('datacity_private_news'), 301);
          }
        }

        // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('DatacityPrivateBundle::addNews.html.twig', array(
            'form' => $form->createView(),
            ));
    }

     public function removeAction(News $news)
    {
        $title = $news->getTitle();
        $news_id = $news->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($news);
        $em->flush();

        $response = new JsonResponse(array('status' => true, 'title' => $title, 'id' => $news_id));
        return $response;
    }

    public function updateAction()
    {

    $form = $this->createForm(new NewsEditType(), $news);

     // Récupère l'utilisateur courant
    $news->setUser($this->get('security.context')->getToken()->getUser());

    $request = $this->getRequest();

    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On enregistre la news
        $em = $this->getDoctrine()->getManager();
        $em->persist($news);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'news bien modifié');

        return $this->redirect($this->generateUrl('datacity_public_news'), 301);
      }
    }

    return $this->render('DatacityPublicBundle::AddNews.html.twig', array(
      'form'    => $form->createView(),
      'news' => $news
    ));
    }

    public function editAction(News $news)
    {
    
    $form = $this->createFormBuilder($news)
                 ->add('title', 'textarea')
                 ->add('message','textarea')
                 ->add('image', new ImageType(), array('required' => false))
                 ->getForm();
                 
    $request = $this->get('request');
    if ($request->getMethod() == 'POST'){
    $form->bind($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($news);
      $em->flush();

    
    return $this->redirect($this->generateUrl('datacity_private_news'), 301);    
      }
    }
    return $this->render('DatacityPrivateBundle::editNews.html.twig', array(
            'form' => $form->createView(),
            ));

    }
}
