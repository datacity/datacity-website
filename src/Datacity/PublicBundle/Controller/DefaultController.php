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
	// Controlleur de la page Home: page statique actuellement,
	// on affiche donc seulement la page d'accueil twig sans donnees dynamiques.
	public function homeAction()
	{
		$response = $this->render('DatacityPublicBundle::home.html.twig');
		return $response;
	}
	
	// Controlleur de la page Contact: page statique actuellement,
	// on affiche donc seulement la page brute de contact twig.
	public function contactAction()
	{
		$response = $this->render('DatacityPublicBundle::contact.html.twig');
		return $response;
	}
	
	
	// Controlleur du portail applicatif. Ici nous recuperons les entites qui sont en DB pour generer le contenu
	// de notre portail applicatif. (On importe ici la liste de toutes les villes et applications).
	public function portalAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		$cities = $this->getDoctrine()->getRepository("DatacityPublicBundle:City")->findAll();	
		$applications = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application")->findAll();
		
		$response = $this->render('DatacityPublicBundle::portal.html.twig', array('filter_cities' => $cities, 'applis' => $applications));
		return $response;
	}
	
	
	// Controlleur pour la page de detail des applications: in ID est passe en parametre a ce controlleur via la route "detail"
	// Cette ID correspond au numero dans l'URL datacity.fr/detail/1 (1 = id)
	// Ici, on recupere l'application desiree pour generer sont contenu dynamiquement depuis la page twig.
	// Si aucune aplication n'existe avec cet ID, une exception est generee.
	public function appDetailAction($id)
	{		
		$app = $this->getDoctrine()
		->getRepository('DatacityPublicBundle:Application')
		->findById($id)[0];
		
		if (!isset($app) || !$app) {
			throw $this->createNotFoundException(
					'Aucune application trouvée pour cet id : '.$id
			);
		}
		
		$response = $this->render('DatacityPublicBundle::appDetail.html.twig', array("appli" => $app));
		return $response;
	}
	//Page de documentation
	public function documentationAction()
	{
		// La prochaine version ira piocher le contenu dans la base de donnee.
		// On recupere la liste des categories et leur contenu qu'on envoi en reponse.
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
		// On match chaque categorie avec leur contenu.
		$docCategoriesContent = array("Categorie 1" => $cat1, "Categorie 2" => $cat2, "Categorie 3" => $cat3);
		$response = $this->render('DatacityPublicBundle::documentation.html.twig', array("docCategories" => $docCategories, "docCategoriesContent" => $docCategoriesContent));
		return $response;
	}
	public function dataviewAction()
	{
		$response = $this->render('DatacityPublicBundle::dataview.html.twig');
		return $response;
	}
	
	//Ancien systeme remplace par les fixtures (a retirer une fois les fixtures totalement finies)
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
