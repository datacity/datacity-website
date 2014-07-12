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
                            'json', SerializationContext::create()->enableMaxDepthChecks()) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function postAction()
    {
<<<<<<< HEAD
        $request = $this->get('request');
        if ($request->isMethod('POST')) {
            $content = $request->getContent();
            if (!empty($content)) {
                // $serializer = $this->get('jms_serializer');
                // $user = $serializer->deserialize($content, 'Datacity\UserBundle\Entity\User', 'json');
                $params = json_decode($content);
                $userManager = $this->get('fos_user.user_manager');
                $user = $this->get('security.context')->getToken()->getUser();
                $user->setFirstname($params->firstname);
                $user->setLastname($params->lastname);
                $user->setAbout($params->about);
                $user->setOccupation($params->occupation);
                $user->setWebsiteUrl($params->websiteUrl);
                $userManager->updateUser($user);
                $response = new JsonResponse(array('action' => 'success'));
            } else {
                $response = new JsonResponse(array('action' => 'failure'));
            }
=======
        $content = $this->get("request")->getContent();

        if (!empty($content)) {
            //$serializer = SerializerBuilder::create()->build();
            $serializer = $this->get('jms_serializer');
            $user = $serializer->deserialize($content, 'Datacity\UserBundle\Entity\User', 'json');

            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $response = new JsonResponse(array('action' => 'success'));
>>>>>>> DSource : Suppression size; Dataset : support multiple categorie; Filtre de recherche : ajout corevageTerritory; + Divers modifs
        } else {
            $response = new JsonResponse(array('action' => 'failure'));
        }
        return $response;
    }

    public function uploadImageAction()
    {
        $request = $this->get('request');
        if ($request->isMethod('POST')) {
            $content = $request->getContent();
            if (!empty($content)) {
                //Pour les images , creer une et set les params un par un,
                //pour le moment on choppe que l'image en base64 et le nom de l'image 
                $params = json_decode($content);
                // $userManager = $this->get('fos_user.user_manager');
                // $user = $this->get('security.context')->getToken()->getUser();
                // $user->setProfileImg($params);
                // $userManager->updateUser($user);
                $response = new JsonResponse(array('action' => $params));
            } else {
                $response = new JsonResponse(array('action' => $request));
            }
        } else {
            $response = new JsonResponse(array('action' => 'failure'));
        }
        // $uploaddir = '/var/www/uploads/';
        // $uploadfile = $uploaddir . basename($_FILES['file']['name']);

        // if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
<<<<<<< HEAD
        //     $response = new JsonResponse(array('action' => 'success')); 
        // else 
        //     $response = new JsonResponse(array('action' => 'failure'));
=======
        //     $response = new JsonResponse(array('action' => 'success'));
        // else
            $response = new JsonResponse(array('action' => 'failure'));
>>>>>>> DSource : Suppression size; Dataset : support multiple categorie; Filtre de recherche : ajout corevageTerritory; + Divers modifs
        return $response;
    }

    public function updatepasswordAction()
    {
       $request = $this->get('request');
        if ($request->isMethod('POST')) {
            $content = $request->getContent();
            if (!empty($content)) {
                $params = json_decode($content);
                $user = $this->get('security.context')->getToken()->getUser();
                $encoder_service = $this->get('security.encoder_factory');
                $encoder = $encoder_service->getEncoder($user);
                $encoded_pass = $encoder->encodePassword($params->oldPassword, $user->getSalt());

                if ($encoded_pass == $user->getPassword()) {
                    $userManager = $this->get('fos_user.user_manager');
                    $user->setPlainPassword($params->newPassword);
                    $userManager->updateUser($user);
                    $response = new JsonResponse(array('action' => 'success'));
                } else {
                    $response = new JsonResponse(array('action' => 'failure'));
                }
            } else {
                $response = new JsonResponse(array('action' => 'failure'));
            }
        } else {
            $response = new JsonResponse(array('action' => 'failure'));
        }
        return $response;
    }
}