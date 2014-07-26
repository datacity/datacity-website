<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Datacity\PublicBundle\Entity\Dataset;
use Symfony\Component\HttpFoundation\Request;

class DataSetController extends Controller
{
    private function thereIsAProblemHere($error = 'failure') {
        return new JsonResponse(array('error' => $error), 400);
    }

    public function saveAction(Request $request) {
        $content = $request->getContent();
        if (!empty($content)) {
            $params = json_decode($content);
            if (!$params)
                return $this->thereIsAProblemHere();

            if (!isset($params->title) || !isset($params->license))
                return $this->thereIsAProblemHere();

            $dataset = new Dataset();
            $dataset->setTitle($params->title);
            if (isset($params->description))
                $dataset->setDescription($params->description);

            $license = $this->getDoctrine()->getRepository("DatacityPublicBundle:License")->findOneByName($params->license);
            if (!$license)
                return $this->thereIsAProblemHere('Unknown license "' . $params->license .'"');
            $dataset->setLicense($license);

            $em = $this->getDoctrine()->getManager();
            $em->persist($dataset);
            $em->flush();
            $response = new JsonResponse(array('result' => $dataset->getSlug()));
        } else {
            return $this->thereIsAProblemHere();
        }
        return $response;
    }

    public function deleteAction(Dataset $dataset) {
        //DELETE ON DOCTRINE THE DATASET
        $response = new JsonResponse(array('action' => 'success'));
        return $response;
    }
}