<?php

namespace Datacity\PrivateBundle\Controller;

use Datacity\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializationContext;

class UserManagerController extends Controller
{
    public function getAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $response = new JsonResponse();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"user":' . $serializer->serialize($user,
                            'json') . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    public function postAction()
    {
        $content = $this->get("request")->getContent();

        if (!empty($content)) {
            //$serializer = SerializerBuilder::create()->build();
            $serializer = $this->get('jms_serializer');
            $user = $serializer->deserialize($content, 'Datacity\UserBundle\Entity\User', 'json');
            
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);
            
            $response = new JsonResponse(array('action' => 'success'));
        } else {
            $response = new JsonResponse(array('action' => 'failure'));
        }
        return $response;
    }
    
    public function uploadImageAction()
    {
        // $content = $this->get("request")->getContent();
        // if (!empty($content)) {
        //     $params = json_decode($content);
        // }
        // $uploaddir = '/var/www/uploads/';
        // $uploadfile = $uploaddir . basename($_FILES['file']['name']);

        // if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
        //     $response = new JsonResponse(array('action' => 'success')); 
        // else 
            $response = new JsonResponse(array('action' => 'failure'));
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