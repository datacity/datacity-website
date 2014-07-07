<?php

namespace Datacity\PrivateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserManagerController extends Controller
{
    public function getAction()
    {
        //Recuperer l'utilisateur, le serialiser et l'envoyer (JSON)
    	$user = $this->get('security.context')->getToken()->getUser();
    	$firstName = $user->getFirstName();
    	$lastName = $user->getLastName();
    	$point = $user->getPoint();
    	$about = $user->getAbout();
    	$joinDate = $user->getJoinDate();
    	$city = $user->getCity();
    	$website = $user->getWebsiteUrl();
        $profileImg = $user->getProfileImg();
    	$response = new JsonResponse(array('firstName' => $firstName, 'lastName' => $lastName, 
    		'point' => $point, 'about' => $about, 'website' => $website, 'joinDate' => $joinDate, 'city' => $city, 'img' => $profileImg));
    	return $response;
    }

    public function postAction()
    {
    	//Enregistrer l'utilisateur en bdd et renvoyer une reponse | Envoyé en methode POST
    	$response = new JsonResponse(array('action' => 'success'));
        return $response;
    }

    public function uploadimageAction()
    {
        //Enregistrer l'image en bdd et renvoyer une reponse (avec l'image) | Envoyé en methode POST
        $response = new JsonResponse(array('action' => 'success'));
        return $response;
    }

    public function updatepasswordAction()
    {
        // $request = $this->get('request');

        // $firstName = "NULLEU";

        // if ($request->getMethod() == 'POST') {
        //     $user = $request->get('user', 'valeur par défaut si bar est inexistant');
        //     $firstName = $user.firstname;
        // }

        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content))
        {
            $params = json_decode($content); // 2nd param to get as array
        }

        //Enregistrer l'utilisateur grace au userManager et renvoyer une reponse | Envoyé en methode POST
        // $encoder_service = $this->get('security.encoder_factory');
        // $encoder = $encoder_service->getEncoder($user);
        // $encoded_pass = $encoder->encodePassword($password, $user->getSalt());

        // if ($encoded_pass == user.oldPassword) {
        //     $userManager = $this->get('fos_user.user_manager');
        //     $user = $userManager->createUser();
        //     //Appliquer le nouveau mot de passe et update le user
        //     $user->setPlainPassword($pass);
        //     $userManager->updateUser($user);
        // }
            // On définit un message flash
        // $this->get('session')->getFlashBag()->add('info', 'Mot de passe modifié');

        echo $params.firstName;

        $response = new JsonResponse(array('action' => 'success'));
        return $response;
    }
}