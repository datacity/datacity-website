<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
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

	public function partialsAction($pageName)
	{
		try {
			$response = $this->get('templating')->renderResponse('DatacityPublicBundle:Partials:' . $pageName . '.html.twig');
			//TODO Configurer le cache HTTP ne devrais pas trop poser de probleme ici.
			return $response;
		} catch (\Exception $ex) {
			throw $this->createNotFoundException('Not Found', $ex);
		}
	}
}
