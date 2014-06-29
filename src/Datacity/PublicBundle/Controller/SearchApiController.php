<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;

class SearchApiController extends Controller
{
    public function searchAction(Request $request)
    {
        $text = $request->query->get('text');
        $place = $request->query->get('place');
        $category = $request->query->get('category');
        $licence = $request->query->get('licence');
        $frequency = $request->query->get('frequency');

        //Ne devrais pas arriver (uniquement si la requete est faite a la main)
        if (!$text && !$place)
        {
            $response = new Response();
            $response->setStatusCode(400);
            return $response;
        }

        $qb = $this->getDoctrine()->getRepository('DatacityPublicBundle:Dataset')->createQueryBuilder('d');

        if ($text)
        {
            $qb->where($qb->expr()->like('d.title', ':text')) //En attendant d'avoir un vrai moteur de recherche fulltext
                ->setParameter('text', "%$text%");
        }

        if ($place)
        {
            $qb->leftJoin('d.places', 'place')
                ->andWhere($qb->expr()->eq('place.name', ':place'))
                ->setParameter('place', $place);
        }

        if ($category)
        {
            $qb->leftJoin('d.category', 'cat')
                ->andWhere($qb->expr()->eq('cat.name', ':category'))
                ->setParameter('category', $category);
        }

        if ($licence)
        {
            $qb->leftJoin('d.licence', 'lic')
                ->andWhere($qb->expr()->eq('lic.name', ':licence'))
                ->setParameter('licence', $licence);
        }

        if ($frequency)
        {
            $qb->leftJoin('d.frequency', 'freq')
                ->andWhere($qb->expr()->eq('freq.name', ':frequency'))
                ->setParameter('frequency', $frequency);
        }
        //TODO KnpPaginatorBundle 
        $response = new Response();
        $results = $qb->getQuery()->getResult();
        $serializer = $this->get('jms_serializer');
        //https://www.owasp.org/index.php/OWASP_AJAX_Security_Guidelines#Always_return_JSON_with_an_Object_on_the_outside
        $response->setContent('{"results":' . $serializer->serialize($results,
                            'json', SerializationContext::create()->setGroups(array('list'))) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function placeAction(Request $request)
    {
        $place = $request->query->get('q');
        if (!$place)
        {
            $response = new Response();
            $response->setStatusCode(400);
            return $response;
        }
        $qb = $this->getDoctrine()->getRepository('DatacityPublicBundle:Place')->createQueryBuilder('p');
        $qb->where('SOUNDEX(p.name) = SOUNDEX(:place)')
            ->orWhere($qb->expr()->like('p.name', ':place'))
            ->setParameter('place', $place.'%')
            ->setMaxResults(10);
        $response = new Response();
        $results = $qb->getQuery()->getResult();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"results":' . $serializer->serialize($results, 'json') . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function searchListFilterAction()
    {
        //Normalement il ne devrais pas avoir une grosse liste de categories/licences/frequences
        $categories = $this->getDoctrine()->getRepository("DatacityPublicBundle:Category")->findAll();
        $licenses = $this->getDoctrine()->getRepository("DatacityPublicBundle:License")->findAll();
        $frequencies = $this->getDoctrine()->getRepository("DatacityPublicBundle:Frequency")->findAll();
        $serializer = $this->get('jms_serializer');
        $results = '{"results":[{"categories":'. $serializer->serialize($categories, 'json') .
                    '},{"licenses":' . $serializer->serialize($licenses, 'json') .
                    '},{"frequencies": ' . $serializer->serialize($frequencies, 'json') . '}]}';
        $response = new Response();
        $response->setContent($results);
        $response->headers->set('Content-Type', 'application/json');
        $response->setPublic();
        //10 min de mise en cache, cela dit pour cette requete de ce type une validation est bien plus adaptee...
        $response->setSharedMaxAge(600);
        $response->setMaxAge(600);
        return $response;
    }

    public function popularAction(Request $request)
    {
        $qb = $this->getDoctrine()->getRepository('DatacityPublicBundle:Dataset')->createQueryBuilder('d');

        $qb->orderBy('d.visitedNb', 'DESC');
        //TODO KnpPaginatorBundle
        
        $response = new Response();
        $results = $qb->getQuery()->getResult();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"results":' . $serializer->serialize($results,
                            'json', SerializationContext::create()->setGroups(array('list'))) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
