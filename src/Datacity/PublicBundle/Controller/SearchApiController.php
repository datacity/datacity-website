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
        $category = json_decode($request->query->get('categories'));
        $licence = json_decode($request->query->get('licenses'));
        $frequency = json_decode($request->query->get('frequencies'));

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
                ->andWhere($qb->expr()->in('cat.name', ':category'))
                ->setParameter('category', $category);
        }

        if ($licence)
        {
            $qb->leftJoin('d.licence', 'lic')
                ->andWhere($qb->expr()->in('lic.name', ':licence'))
                ->setParameter('licence', $licence);
        }

        if ($frequency)
        {
            $qb->leftJoin('d.frequency', 'freq')
                ->andWhere($qb->expr()->in('freq.name', ':frequency'))
                ->setParameter('frequency', $frequency);
        }

        $qb->orderBy('d.visitedNb', 'DESC');
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
        $qb->//where('SOUNDEX(p.name) = SOUNDEX(:place)')
            ->where($qb->expr()->like('p.name', ':place'))
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
        $coverage = $this->getDoctrine()->getRepository("DatacityPublicBundle:CoverageTerritory")->findAll();
        $serializer = $this->get('jms_serializer');
        $results = '{"results":{"categories":'. $serializer->serialize($categories, 'json') .
                    ',"licenses":' . $serializer->serialize($licenses, 'json') .
                    ',"frequencies": ' . $serializer->serialize($frequencies, 'json') .
                    ',"coverageTerritory": ' . $serializer->serialize($coverage, 'json') . '}}';
        $response = new Response();
        $response->setContent($results);
        $response->headers->set('Content-Type', 'application/json');
        $response->setPublic();
        //10 min de mise en cache, cela dit pour cette requete de ce type une validation est bien plus adaptee...
        $response->setSharedMaxAge(600);
        $response->setMaxAge(600);
        return $response;
    }
}
