<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataSetController extends Controller
{
    public function deleteAction() {
    	//DELETE ON DOCTRINE THE DATASET
    }
    public function saveAction() {
    	//PERSIST ON DOCTRINE THE DATASET
    }
    public function getAction($id) {
    	$response = new JsonResponse(array('title' => 'Mon api marche', 'description' => "je suis une description de test avant de charger dynamiquement les données dont jai besoin"));
        return $response;
    	// LOAD FROM DOCTRINE THE DATASET AND SEND IT TON THE RETURN	
    }

}