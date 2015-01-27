<?php

namespace Datacity\PrivateBundle\Controller;

use Datacity\UserBundle\Entity\User;
use Datacity\PrivateBundle\Entity\Newsletter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;

class NewslettersController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $newsletters = $this->getDoctrine()->getRepository("DatacityPrivateBundle:Newsletter")->findAll();
        $response = $this->render('DatacityPrivateBundle::newsletter.html.twig', array('newsletters' => $newsletters));
        return $response;
    }

    public function removeAction(Newsletter $newsletter)
    {
        $slug = $newsletter->getSlug();

        $em = $this->getDoctrine()->getManager();
        $em->remove($newsletter);
        $em->flush();

        $response = new JsonResponse(array('status' => true,
                                        'slug' => $slug));
        return $response;
    }

    public function addAction(Request $request)
    {
        $newsletter = new Newsletter();
        $form = $this->createFormBuilder($newsletter)
                        ->add('object', null)
                        ->add('message','textarea')
                        ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            return $this->redirect($this->generateUrl('datacity_private_admin_newsletter'));
        }

        return $this->render('DatacityPrivateBundle::addNewsletter.html.twig', array(
                'form' => $form->createView(),
                ));
    }
}
