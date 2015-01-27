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

    public function launchAction(Newsletter $newsletter) {
        $message = "";
        if ($newsletter->getLaunched()) {
            $message = "La newsletter a déjà été envoyée.";
            return $this->render('DatacityPrivateBundle::newsletterLaunched.html.twig', array('message' => $message));
        }

        $mailer = $this->get('mailer');
        $message = $mailer->createMessage()
            ->setSubject($newsletter->getObject())
            ->setFrom('datacity.eip@gmail.com')
            ->setBody(
                $this->renderView(
                    'DatacityPrivateBundle:Mail:template.html.twig',
                    array('message' => $newsletter->getMessage(),
                        'homepage' => $this->get('router')->generate('datacity_public_homepage', array(), true))),
                'text/html');

        $users = $this->getDoctrine()->getRepository("DatacityUserBundle:User")->findByReceiveNewsletter(true);
        $numSent = 0;

        foreach($users as $user) {
            $message->setTo($user->getEmailCanonical());
            $numSent += $mailer->send($message);
        }

        $message = 'La newsletter a été envoyée (' . $numSent . ' destinataires)';

        $newsletter->setLaunched(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($newsletter);
        $em->flush();
        return $this->render('DatacityPrivateBundle::newsletterLaunched.html.twig', array('message' => $message));
    }
}
