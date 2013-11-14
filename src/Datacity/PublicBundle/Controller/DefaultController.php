<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\PublicBundle\Entity\Application;
use Datacity\PublicBundle\Entity\Image;
use Datacity\PublicBundle\Entity\City;
use Datacity\PublicBundle\Entity\Customer;
use Datacity\PublicBundle\Entity\Platform;
use Datacity\PublicBundle\Entity\Category;
use Datacity\PublicBundle\Entity\News;


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
		$em = $this->getDoctrine()->getManager();
		
		$villes = $this->getDoctrine()->getRepository("DatacityPublicBundle:City");
		$categories = $this->getDoctrine()->getRepository("DatacityPublicBundle:Category");
		$platforms = $this->getDoctrine()->getRepository("DatacityPublicBundle:Platform");
		
		
		$repo = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application");
		$applications = $repo->findAll();
		
		
		
		$cities = $villes->findAll();
		
		$response = $this->render('DatacityPublicBundle::portal.html.twig', array('filter_cities' => $cities, 'apps' => $applications));
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
		
		
		$response = $this->render('DatacityPublicBundle::appDetail.html.twig', array("appli" => $app));
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
	public function initdbAction()
	{
		$em = $this->getDoctrine()->getManager();
		// Création des données News
		/*$news = new News;
		$news->setTitle('Test1');
		$news->setUser('Cynt');
		$news->setMessage("Message pour l'article numero un");
		$news->setDate("15.08.2013");
		$news->setImg("http://www.businesscomputingworld.co.uk/wp-content/uploads/2012/08/Cool-City.jpg");
		
		$news2 = new News;
		$news2->setTitle('Test2');
		$news2->setUser('Marco');
		$news2->setMessage("Message pour l'article numero deux");
		$news2->setDate("10.07.2013");
		$news2->setImg("http://senseable.mit.edu/copenhagenwheel/pix_urbanData/data_02.jpg");
		
		$news3 = new News;
		$news3->setTitle('Test3');
		$news3->setUser('Cedric');
		$news3->setMessage("Message pour l'article numero trois");
		$news3->setDate("22.05.2013");
		$news3->setImg("http://www.clandoustphotography.co.uk/images/banner_bridges1.jpg");
		
		
		$em->persist($news);
		$em->persist($news2);
		$em->persist($news3);*/
		
		// Creation des category
				
		/*	$noms = array('Culture', 'Itinéraire', 'Tourisme', 'Évènement', 'Concerts', 'Musique', 'Cinémas');
		
			foreach($noms as $i => $name)
			{
				// On crée la catégorie
				$liste_categories[$i] = new Category();
				$liste_categories[$i]->setName($name);
		
				// On la persiste
				$em->persist($liste_categories[$i]);
			}*/
		
		
		//$em->flush();
		
		
		//$applications = $repo->findAll();
		
		
		
		//$cities = $villes->findAll();
		
		//$response = $this->render('DatacityPublicBundle::portal.html.twig', array('filter_cities' => $cities, 'applis' => $applications));
		
		//return $response;
		//return ("Initialisation de la DB finie.");
	
		
	}
	public function dataViewDetailAction($id)
	{
		$response = $this->render('DatacityPublicBundle::dataViewDetail.html.twig');
		return $response;
	}
	public function newsAction()
	{
		
		$em = $this->getDoctrine()->getManager();
		
		$categories = $this->getDoctrine()->getRepository("DatacityPublicBundle:Category");
		$news = $this->getDoctrine()->getRepository("DatacityPublicBundle:News");
		
		$news = $news->findAll();
		
		$categories = $categories->findAll();
		
		
		$response = $this->render('DatacityPublicBundle::news.html.twig', array('news' => $news, 'categories' => $categories));
		return $response;
	}
}
