<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\PublicBundle\Entity\Application;
use Datacity\PublicBundle\Entity\Image;
use Datacity\PublicBundle\Entity\City;
use Datacity\PublicBundle\Entity\Platform;
use Datacity\PublicBundle\Entity\Category;
use Datacity\PublicBundle\Entity\News;


class DefaultController extends Controller
{
	// Controlleur de la page Home: page statique actuellement,
	// on affiche donc seulement la page d'accueil twig sans donnees dynamiques.
	public function homeAction()
	{
		$applications = $this->getDoctrine()->getRepository("DatacityPublicBundle:Application")->findAll();
		
		$response = $this->render('DatacityPublicBundle::home.html.twig', array('applis' => $applications));
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
					'Aucune application trouvée pour l\'id '.$id
			);
		}
		
		/*$userManager = $this->container->get('fos_user.user_manager');
		$users = $userManager->findUsers();
		
		
		foreach ($users as $user) {
			$response .= $user->getUsername();
		}		*/
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
	
	// Controller de la page visualisation des données
	public function dataviewAction()
	{
		$response = $this->render('DatacityPublicBundle::dataview.html.twig');
		return $response;
	}
	
	// Controller de la page detail d'une donnée on envoit l'id en parametre de la donnée selectionnée par l'utilisateur.
	// Cette page permet d'afficher plus de details sur une données présente dans la page visualisation des données.
	public function dataViewDetailAction($id)
	{
		$response = $this->render('DatacityPublicBundle::dataViewDetail.html.twig');
		return $response;
	}
	
	// Controller de la page News
	// Dans ce controller nous récupérons également l'ensemble des catégories car nous avons besoins de les réafficher sur la page de news.
	public function newsAction()
	{
		
		$em = $this->getDoctrine()->getManager();
		//Récupération des catégory qui sont en base
		$categories = $this->getDoctrine()->getRepository("DatacityPublicBundle:Category");
		$categories = $categories->findAll();
		
		// Récupération des news qui sont en base
		$news = $this->getDoctrine()->getRepository("DatacityPublicBundle:News");
		$news = $news->findAll();
		
		//Redirection vers la page news en envoyant le tableau de news et de categories initialisé précédement.
		$response = $this->render('DatacityPublicBundle::news.html.twig', array('news' => $news, 'categories' => $categories));
		return $response;
	}
	
	public function newsDetailAction(News $news)
	{
		return $this->render('DatacityPublicBundle::newsDetail.html.twig', array("news" => $news));
	}
}
