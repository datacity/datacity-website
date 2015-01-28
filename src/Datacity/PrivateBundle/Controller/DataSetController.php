<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Datacity\PublicBundle\Entity\Dataset;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;

class DataSetController extends Controller
{
    const ITEM_PER_REQUEST = 12;
    const POINT_PER_DATASET = 5;

    private function thereIsAProblemHere($error = 'failure') {
        return new JsonResponse(array('error' => $error), 400);
    }

    private function handleDataset(Request $request, Dataset $dataset = null, $create = true) {
        $content = $request->getContent();
        if (!empty($content)) {
            $params = json_decode($content);
            if (!$params)
                return $this->thereIsAProblemHere();

            if (!isset($params->title) || !isset($params->license) || !isset($params->visibility))
                return $this->thereIsAProblemHere('Missing parameters');

            if ($create) {
                $dataset = new Dataset();
            }

            $dataset->setTitle($params->title);
            if (isset($params->description))
                $dataset->setDescription($params->description);

            $license = $this->getDoctrine()->getRepository("DatacityPublicBundle:License")->findOneByName($params->license);
            if (!$license)
                return $this->thereIsAProblemHere('Unknown license "' . $params->license .'"');
            $dataset->setLicense($license);

            $dataset->setIsPublic($params->visibility == "public");

            if ($create) {
                $user = $this->getUser();
                $userManager = $this->get('fos_user.user_manager');
                $user->setPoint($user->getPoint() + self::POINT_PER_DATASET);
                $userManager->updateUser($user);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($dataset);
            $em->flush();
            $response = new JsonResponse(array('result' => $dataset->getSlug()));
        } else {
            return $this->thereIsAProblemHere();
        }
        return $response;
    }

    public function addAction(Request $request) {
        return $this->handleDataset($request);
    }

    public function saveAction(Request $request, Dataset $dataset) {
        return $this->handleDataset($request, $dataset, false);
    }

    public function deleteAction(Dataset $dataset) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($dataset);
        $em->flush();
        $response = new JsonResponse(array('action' => 'success'));
        return $response;
    }

    public function getAction($offset) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $results = $em->createQueryBuilder()->select('d')
                  ->from('DatacityPublicBundle:Dataset', 'd')
                  ->where('d.creator = ?1')
                  ->setParameter(1, $user->getId())
                  ->setFirstResult($offset)
                  ->setMaxResults(self::ITEM_PER_REQUEST)
                  ->getQuery()->getResult();
        $response = new Response();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"results":' . $serializer->serialize($results,
                            'json', SerializationContext::create()->setGroups(array('userList'))) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}