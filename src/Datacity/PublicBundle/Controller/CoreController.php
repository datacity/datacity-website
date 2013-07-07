<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function homeAction()
    {
        return $this->render('DatacityPublicBundle:Core:home.html.twig');
    }
}
