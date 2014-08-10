<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DatacityPrivateBundle::index.html.twig');
    }

    public function modalsAction($pageName) {
        try {
            $response = $this->render('DatacityPrivateBundle:Modals:' . $pageName . '.html.twig');
            return $response;
        } catch (\Exception $ex) {
            throw $this->createNotFoundException();
        }
    }
}
