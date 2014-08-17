<?php

namespace Datacity\PrivateBundle\Controller;

use Datacity\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializationContext;

class ProducersController extends Controller
{
    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();
        $producers = $this->getDoctrine()->getRepository("DatacityPublicBundle:Producer")->findAll();
        $response = new JsonResponse();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"producers":' . $serializer->serialize($producers,
                            'json', SerializationContext::create()->enableMaxDepthChecks()) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}