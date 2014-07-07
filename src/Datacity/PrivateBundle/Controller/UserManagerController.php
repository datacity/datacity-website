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
        $content = $this->get("request")->getContent();
        if (!empty($content)) {
            $params = json_decode($content);
        }

        $user = $this->get('security.context')->getToken()->getUser();
        $encoder_service = $this->get('security.encoder_factory');
        $encoder = $encoder_service->getEncoder($user);
        $encoded_pass = $encoder->encodePassword($params->oldPassword, $user->getSalt());

        if ($encoded_pass == $user->getPassword()) {
            $userManager = $this->get('fos_user.user_manager');
            //Applique le nouveau mot de passe et update le user
            $user->setPlainPassword($params->newPassword);
            $userManager->updateUser($user);
            $response = new JsonResponse(array('action' => 'success'));
        } else {
            $response = new JsonResponse(array('action' => 'failure'));
        }

        return $response;
    }
}