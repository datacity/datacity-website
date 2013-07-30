<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
		$projects = array(
				1 => array('app_id' => 1, 'app_name' => 'Datacity Tourism', 'app_description' => 'Application de référencement des principaux lieux touristiques.', 'app_images' => array("http://www.caledonianpost.com/wp-content/uploads/2013/04/android.jpg", "http://www.theartoftylerjordan.com/newsite_images/Illustration/concepts/googlebot.jpg"), 'app_platforms' => array("iOs", "Android", "Blackberry", "Windows Phone")),
				2 => array('app_id' => 2, 'app_name' => 'Datacity Culture', 'app_description' => 'Application de référencement des principaux lieux culturels.', 'app_images' => array("http://www.baggy.no/wp-content/uploads/2012/06/google_%C3%A5pner_live_videotjeneste_09052012.png", "http://www.king-david-crown.com/images/temp_flash_window_fr.jpg"), 'app_platforms' => array("iOs", "Android", "Blackberry", "Windows Phone")),
				3 => array('app_id' => 3, 'app_name' => 'Datacity Street', 'app_description' => 'Application de référencement des principales rues. ^^', 'app_images' => array("http://www.giornalettismo.com/wp-content/uploads/2012/12/screen-shot-2012-12-12-at-11-13-53-pm-770x310.png", "http://www.clandoustphotography.co.uk/images/banner_bridges1.jpg"), 'app_platforms' => array("iOs", "Android", "Blackberry", "Windows Phone")));
		$response = $this->render('DatacityPublicBundle::portal.html.twig', array('filter_cities' => $villes, 'projects' => $projects));
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
		$response = $this->render('DatacityPublicBundle::appDetail.html.twig', array("app_id" => $id, "app_name" => $name, "app_categories" => $cats, "app_client" => $client, "app_platforms" => $platforms, "app_images" => $images, "app_description" => $description, "app_url" => $url, "app_downloaded" => $downloaded));
		return $response;
	}
	public function documentationAction()
	{
		$response = $this->render('DatacityPublicBundle::documentation.html.twig');
		return $response;
	}
	public function dataviewAction()
	{
		$response = $this->render('DatacityPublicBundle::dataview.html.twig');
		return $response;
	}
}
