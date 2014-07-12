<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;
use Datacity\PublicBundle\Entity\Dataset;

class DatasetApiController extends Controller
{
    public function showAction(Dataset $dataset)
    {
        //Pas de check IP pour le moment... (https://github.com/l3pp4rd/DoctrineExtensions/blob/master/doc/ip_traceable.md)
        $dataset->setVisitedNb($dataset->getVisitedNb() + 1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($dataset);
        $em->flush();
        $response = new Response();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"results":' . $serializer->serialize($dataset,
                            'json', SerializationContext::create()->setGroups(array('datasetShow'))) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    //TODO
    public function voteAction()
    {

    }

    public function getModelAction(Dataset $dataset)
    {
        $dataColumns = $dataset->getColumns();

        $response = new Response();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"results":' . $serializer->serialize($dataColumns, 'json') . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
