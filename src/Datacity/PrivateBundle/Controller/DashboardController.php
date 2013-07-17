<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
    	return $this->render('DatacityPrivateBundle::dashboard.html.twig');
    }
}
