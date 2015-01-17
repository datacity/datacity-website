<?php

namespace Datacity\PrivateBundle\Controller;

use Datacity\UserBundle\Entity\User;
use Datacity\PublicBundle\Entity\Image;
use Doctrine\ORM\EntityRepository;
use Datacity\PublicBundle\Entity\Application;
use Datacity\PublicBundle\Entity\Dataset;
use Datacity\PublicBundle\Entity\Category;
use Datacity\PublicBundle\Entity\Platform;
use Datacity\PublicBundle\Entity\City;
use Datacity\PrivateBundle\Entity\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;

use \Datetime;

class ApplicationsController extends Controller
{
    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();
        $applications = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application")->findAll();
        $response = new JsonResponse();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"applications":' . $serializer->serialize($applications,
                            'json', SerializationContext::create()->enableMaxDepthChecks()) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
	
    public function getUserApplicationsAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $results = $em->createQueryBuilder()->select('d')
                  ->from('DatacityPublicBundle:Application', 'd')
                  ->where('d.user = ?1')
                  ->setParameter(1, $user->getId())
                  ->getQuery()->getResult();
        $response = new Response();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"results":' . $serializer->serialize($results,
                            'json', SerializationContext::create()->setGroups(array('userApplications'))) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function editAction(Application $application)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        /*$application->setUser($user);
        $application->setDownloaded($application->getDownloaded());*/


        $form = $this->createFormBuilder($application)
                 ->add('name', 'textarea')
                 ->add('description','textarea')
                 ->add('city', 'entity', array(
                    'class' => 'DatacityPublicBundle:City',
                    'property' => 'name',
                    'multiple' => false,
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('g')
                      ->orderBy('g.name', 'ASC');
                      },
                  ))
                 ->add("images", "collection", array("type" => new ImageType()))
                 ->add('categories', 'entity', array(
                    'class' => 'DatacityPublicBundle:Category',
                    'property' => 'name',
                    'multiple' => true,
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('g')
                      ->orderBy('g.name', 'ASC');
                      },
                    ))
                 ->add('platforms', 'entity', array(
                    'class' => 'DatacityPublicBundle:Platform',
                    'property' => 'name',
                    'multiple' => true,
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('g')
                      ->orderBy('g.name', 'ASC');
                      },
                    ))
                 ->add('dataset', 'entity', array(
                    'class' => 'DatacityPublicBundle:Dataset',
                    'property' => 'title',
                    'multiple' => false,
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('g')
                      ->orderBy('g.title', 'ASC');
                      },
                    ))
                ->getForm();
         
    $request = $this->get('request');
    if ($request->getMethod() == 'POST'){
    $form->bind($request);

    if ($form->isValid()) {
      $application->setUrl($application->getName());
      $em = $this->getDoctrine()->getManager();
      $em->persist($application);
      //
      $em->flush();

    
    return $this->redirect($this->generateUrl('datacity_private_applications_list'), 301);    
      }
    }
  return $this->render('DatacityPrivateBundle::editApplications.html.twig', array(
            'form' => $form->createView(),
            ));

    }

  public function getAppAction($slug) 
    {
        $em = $this->getDoctrine()->getManager();
        $results = $em->createQueryBuilder()->select('d')
                  ->from('DatacityPublicBundle:Application', 'd')
                  ->where('d.slug = ?1')
                  ->setParameter(1, $slug)
                  ->getQuery()->getResult();
        $response = new Response();
        $serializer = $this->get('jms_serializer');
        $response->setContent('{"results":' . $serializer->serialize($results[0],
                            'json', SerializationContext::create()->setGroups(array('userApplications'))) . '}');
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

	public function listAction()
	{
		$em = $this->getDoctrine()->getManager();
        $applications = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application")->findAll();		
		$response = $this->render('DatacityPrivateBundle::applications.html.twig', array('applications' => $applications));
    	return $response;
	}
	
	public function removeAction(Application $application)
    {
        $name = $application->getName();
        $application_id = $application->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($application);
        $em->flush();

        $response = new JsonResponse(array('status' => true, 'name' => $name, 'id' => $application_id));
        return $response;
    }
	
  public function dash($item) {

      return "{" . '"name"' . ":" . $item->getName() . '}';
  }

  public function dash2($item) {

      return $item->getTitle();
  }

  public function getAppDataAction()
    {
        $categories = $this->getDoctrine()->getRepository("DatacityPublicBundle:Category")->findAll();
        $cities = $this->getDoctrine()->getRepository("DatacityPublicBundle:City")->findAll();
        $platforms = $this->getDoctrine()->getRepository("DatacityPublicBundle:Platform")->findAll();
        $datasets = $this->getDoctrine()->getRepository("DatacityPublicBundle:Dataset")->findAll();
        foreach($categories as $c){
          $cat = new Category();
          $cat->setName($c->getName());
          $categories_name[] = $cat;
        }
        foreach ($datasets as $d){
          $dat = new Dataset();
          $dat->setTitle($d->getTitle());
          $datasets_name[] = $dat;
        }
        foreach ($platforms as $p){
          $plat = new Platform();
          $plat->setName($p->getName());
          $platforms_name[] = $plat;
        }
        $cities_name = array_map(array($this, 'dash'), $cities);

        $serializer = $this->get('jms_serializer');
        $results = '{"results":{"categories":'. $serializer->serialize($categories_name, 'json') .
                    ',"cities":' . $serializer->serialize($cities, 'json') .
                    ',"platforms": ' . $serializer->serialize($platforms_name, 'json') .
                    ',"datasets": ' . $serializer->serialize($datasets_name, 'json') . '}}';
        $response = new Response();
        $response->setContent($results);
        $response->headers->set('Content-Type', 'application/json');
        $response->setPublic();
        return $response;
    }

  public function deleteUserAppAction(Request $request)
  {
    $content = $request->getContent();
        if (!empty($content)) 
        {
            $params = json_decode($content);
            if (!$params)
                return $this->thereIsAProblemHere();
            $app = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application")->findOneBySlug($params->slug);
            $em = $this->getDoctrine()->getManager();
            $em->remove($app);
            $em->flush();
        }
        $response = new JsonResponse(array('result' => 'app_deleted'));
        return $response; 
  }

  public function postUserAppAction(Request $request)
  {
      $content = $request->getContent();
        if (!empty($content)) {
            $params = json_decode($content);
            if (!$params)
                return $this->thereIsAProblemHere();

            if (!isset($params->name) || !isset($params->city))
                return $this->thereIsAProblemHere();

            if ($params->operation == 'edit'){
              $application = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application")->findOneBySlug($params->slug);
              $application->removePlatforms();
              $application->removeCategories();
            }
            else if ($params->operation == 'add')
              $application = new Application();
            $user = $this->get('security.context')->getToken()->getUser();
            $application->setName($params->name);
            $application->setSlug($params->name);
            $application->setUrl($params->name);
            $application->setDownloaded($params->downloaded);
            if (isset($params->description))
                $application->setDescription($params->description);

            $city = $this->getDoctrine()->getRepository("DatacityPublicBundle:City")->findOneByName($params->city);
            $dataset = $this->getDoctrine()->getRepository("DatacityPublicBundle:Dataset")->findOneByTitle($params->dataset);
            foreach ($params->categories as $cat) {
              $category = $this->getDoctrine()->getRepository("DatacityPublicBundle:Category")->findOneByName($cat);
              $application->addCategory($category);
            }
            foreach ($params->platforms as $plat) {
              $platform = $this->getDoctrine()->getRepository("DatacityPublicBundle:Platform")->findOneByName($plat);
              $application->addPlatform($platform);
            }

            if (!$city)
                return $this->thereIsAProblemHere('Unknown license "' . $params->city .'"');
            $application->setCity($city);
            $application->setDataset($dataset);

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();
            $response = new JsonResponse(array('result' => $application->getName()));
        } 
        else
            return $this->thereIsAProblemHere();
        return $response;

  }

  private function thereIsAProblemHere($error = 'failure') {
        return new JsonResponse(array('error' => $error), 400);
    }

	public function postAction() 
	{

	$user = $this->get('security.context')->getToken()->getUser();
  $application = new Application();
  $application->setUser($user);
  $application->setDownloaded(0);

	$form = $this->createFormBuilder($application)
                 ->add('name', 'textarea')
                 ->add('description','textarea')
                 ->add('city', 'entity', array(
                    'class' => 'DatacityPublicBundle:City',
                    'property' => 'name',
                    'multiple' => false,
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('g')
                      ->orderBy('g.name', 'ASC');
                      },
                  ))
				         ->add("images", "collection", array("type" => new ImageType()))
                 ->add('categories', 'entity', array(
                    'class' => 'DatacityPublicBundle:Category',
                    'property' => 'name',
                    'multiple' => true,
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('g')
                      ->orderBy('g.name', 'ASC');
                      },
                    ))
                 ->add('platforms', 'entity', array(
                    'class' => 'DatacityPublicBundle:Platform',
                    'property' => 'name',
                    'multiple' => true,
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('g')
                      ->orderBy('g.name', 'ASC');
                      },
                    ))
                 ->add('dataset', 'entity', array(
                    'class' => 'DatacityPublicBundle:Dataset',
                    'property' => 'title',
                    'multiple' => false,
                    'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('g')
                      ->orderBy('g.title', 'ASC');
                      },
                    ))
                ->getForm();
				 
    $request = $this->get('request');
    if ($request->getMethod() == 'POST'){
    $form->bind($request);

    if ($form->isValid()) {
      $application->setUrl($application->getName());
      $em = $this->getDoctrine()->getManager();
      $em->persist($application);
      //
      $em->flush();

    
    return $this->redirect($this->generateUrl('datacity_private_applications_list'), 301);    
      }
    }
	return $this->render('DatacityPrivateBundle::addApplications.html.twig', array(
            'form' => $form->createView(),
            ));
	}

}
