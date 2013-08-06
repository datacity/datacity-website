<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\PublicBundle\Entity\Application;
use Datacity\PublicBundle\Entity\Image;

class DefaultController extends Controller
{
	public function homeAction()
	{
		$response = $this->render('DatacityPublicBundle::home.html.twig');
		return $response;
	}
	public function contactAction()
	{
		$response = $this->render('DatacityPublicBundle::contact.html.twig');
		return $response;
	}
	public function portalAction()
	{
		$villes = array("Montpellier", "Paris", "Lille", "Bordeaux", "Lyon", "Marseille");
		/*$application = new Application();
		$application->setName('Datacity Street');
		$application->setDescription('Application de référencement des principales rues. ^^');
		
		$image1 = new Image();
		$image1->setUrl("http://www.giornalettismo.com/wp-content/uploads/2012/12/screen-shot-2012-12-12-at-11-13-53-pm-770x310.png");
		$image1->setAlt("Premiere image Street");
		$image1->setApplication($application);
		
		$image2 = new Image();
		$image2->setUrl("http://www.clandoustphotography.co.uk/images/banner_bridges1.jpg");
		$image2->setAlt("Seconde image Street");
		$image2->setApplication($application);
		*/
				
		$repo = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application");
		$applications = $repo->findAll();
		
		/*$em = $this->getDoctrine()->getManager();
		
		foreach ($applications as $key => $value)
		{
			$appli = $applications[$key];
		}
		
		$em->remove($appli);
		$em->flush();*/
		
		$response = $this->render('DatacityPublicBundle::portal.html.twig', array('filter_cities' => $villes, 'apps' => $applications));
		return $response;
	}
	public function appDetailAction($id)
	{
		$name = "DataCity Tourism";
		$description = "Application de référencement des principaux lieux culturels, historiques et touristiques.";
		$cats =  array("Tourisme", "Loisirs", "Histoire");
		$client = "Montpellier";
		$platforms =  array("iOs", "Android", "Blackberry", "Windows Phone");
		$images = array("http://www.caledonianpost.com/wp-content/uploads/2013/04/android.jpg", "http://www.theartoftylerjordan.com/newsite_images/Illustration/concepts/googlebot.jpg");
		$url = "http://www.google.fr/";
		$downloaded = 1423;
		
		$apps = $this->getDoctrine()
		->getRepository('DatacityPublicBundle:Application')
		->findById($id);
		
		foreach ($apps as $value)
		{
			$app = $value;
		}
		
		if (!isset($app) || !$app) {
			throw $this->createNotFoundException(
					'Aucune application trouvée pour cet id : '.$id
			);
		}
		
		
		$response = $this->render('DatacityPublicBundle::appDetail.html.twig', array("appli" => $app, "app_categories" => $cats, "app_client" => $client, "app_platforms" => $platforms, "app_url" => $url, "app_downloaded" => $downloaded));
		return $response;
	}
	public function documentationAction()
	{
		$docCategories = array("Categorie 1", "Categorie 2",  "Categorie 3");
		$cat1 = array(
			1 => array("subCategorieTitle" => "Sous Categorie 11", "docContent" => "Contenu 1"),
			2 => array("subCategorieTitle" => "Sous Categorie 12", "docContent" => "Contenu 2"),
			3 => array("subCategorieTitle" => "Sous Categorie 13", "docContent" => "Contenu 3")
			);
		$cat2 = array(
			1 => array("subCategorieTitle" => "Sous Categorie 21", "docContent" => "Contenu 1"),
			2 => array("subCategorieTitle" => "Sous Categorie 22", "docContent" => "Contenu 2"),
			3 => array("subCategorieTitle" => "Sous Categorie 23", "docContent" => "Contenu 3")
			);
		$cat3 = array(
			1 => array("subCategorieTitle" => "Sous Categorie 31", "docContent" => "Contenu 1"),
			2 => array("subCategorieTitle" => "Sous Categorie 32", "docContent" => "Contenu 2"),
			3 => array("subCategorieTitle" => "Sous Categorie 33", "docContent" => "Contenu 3")
			);
		$docCategoriesContent = array("Categorie 1" => $cat1, "Categorie 2" => $cat2, "Categorie 3" => $cat3);
		$response = $this->render('DatacityPublicBundle::documentation.html.twig', array("docCategories" => $docCategories, "docCategoriesContent" => $docCategoriesContent));
		return $response;
	}
	public function dataviewAction()
	{
		$response = $this->render('DatacityPublicBundle::dataview.html.twig');
		return $response;
	}
}
