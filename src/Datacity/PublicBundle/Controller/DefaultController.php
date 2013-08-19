<?php

namespace Datacity\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Datacity\PublicBundle\Entity\Application;
use Datacity\PublicBundle\Entity\Image;
use Datacity\PublicBundle\Entity\City;
use Datacity\PublicBundle\Entity\Customer;
use Datacity\PublicBundle\Entity\Platform;
use Datacity\PublicBundle\Entity\Category;

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
	public function initdbAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		$villes = $this->getDoctrine()->getRepository("DatacityPublicBundle:City")->findAll();
		if (!$villes)
		{
		
		$noms = array('Culture', 'Itinéraire', 'Tourisme', 'Évènement', 'Concerts', 'Musique', 'Cinémas');
		
		foreach($noms as $i => $name)
		{
		// On crée la catégorie
		$liste_categories[$i] = new Category();
		$liste_categories[$i]->setName($name);
		
		// On la persiste
		$em->persist($liste_categories[$i]);
		}
		
		$noms = array('iOS', 'Android', 'Windows Phone', 'Blackberry');
		$versions = array('7.0', '4.3', '7.8', '7.1');
		foreach($noms as $i => $name)
		{
		$liste_platforms[$i] = new Platform();
		$liste_platforms[$i]->setName($name);
		$liste_platforms[$i]->setVersion($versions[$i]);
		$em->persist($liste_platforms[$i]);
		}
		
		$noms = array('Montpellier', 'Ales', 'Nimes', 'Paris', 'Lyon', 'Catalogne (village)');
		
		foreach($noms as $i => $name)
		{
		$liste_cities[$i] = new City();
		$liste_cities[$i]->setName($name);
		
		$em->persist($liste_cities[$i]);
		}
		$em->flush();
		
		$villes = $this->getDoctrine()->getRepository("DatacityPublicBundle:City");
		$categories = $this->getDoctrine()->getRepository("DatacityPublicBundle:Category");
		$platforms = $this->getDoctrine()->getRepository("DatacityPublicBundle:Platform");
		
		$customer = new Customer();
		$customer->setCity($villes->findOneByName("Paris"));
		$customer->setContactFirstName("Lionel");
		$customer->setContactLastName("Samsoul");
		$customer->setContactMail("lionel.samsoul@gmail.com");
		$customer->setContactPhone("0605075855");
		$customer->setName("Paris Mairie");
		$customer->setSiret("878932645");
		
		
		$application = new Application();
		$application->setName('Datacity Culture');
		$application->setUrl('http://www.url-culture.fr');
		$application->setDescription('Application de référencement des principaux lieux culturels');
		$application->setCity($villes->findOneByName("Paris"));
		$application->addCategorie($categories->findOneByName("Musique"));
		$application->addCategorie($categories->findOneByName("Concerts"));
		$application->setDownloaded(6879);
		$application->setCustomer($customer);
		$application->addPlatform($platforms->findOneByName("iOS"));
		$application->addPlatform($platforms->findOneByName("Windows Phone"));
		$application->addPlatform($platforms->findOneByName("Android"));
		$application->addPlatform($platforms->findOneByName("Blackberry"));
		
		$image1 = new Image();
		$image1->setUrl("http://www.businesscomputingworld.co.uk/wp-content/uploads/2012/08/Cool-City.jpg");
		$image1->setAlt("Premiere image Culture");
		$image1->setApplication($application);
		
		$image2 = new Image();
		$image2->setUrl("http://senseable.mit.edu/copenhagenwheel/pix_urbanData/data_02.jpg");
		$image2->setAlt("Seconde image Culture");
		$image2->setApplication($application);
		
		$customer->addApplication($application);
		
		
		$em->persist($customer);
		$em->persist($application);
		$em->persist($image1);
		$em->persist($image2);
		

		
		$customer2 = new Customer();
		$customer2->setCity($villes->findOneByName("Montpellier"));
		$customer2->setContactFirstName("Pierro");
		$customer2->setContactLastName("Dujardin");
		$customer2->setContactMail("pierrodujardin@gmail.com");
		$customer2->setContactPhone("032423123445");
		$customer2->setName("Montpellier Mairie");
		$customer2->setSiret("23231313231");
		
		
		$application2 = new Application();
		$application2->setName('Datacity Street');
		$application2->setUrl("http://www.url-street.fr/");
		$application2->setDescription('Application de référencement des principales rues. ^^');
		$application2->setCity($villes->findOneByName("Montpellier"));
		$application2->addCategorie($categories->findOneByName("Culture"));
		$application2->addCategorie($categories->findOneByName("Tourisme"));
		$application2->setDownloaded(434);
		$application2->setCustomer($customer2);
		$application2->addPlatform($platforms->findOneByName("iOS"));
		$application2->addPlatform($platforms->findOneByName("Blackberry"));
		
		$image3 = new Image();
		$image3->setUrl("http://www.clandoustphotography.co.uk/images/banner_bridges1.jpg");
		$image3->setAlt("Premiere image Street");
		$image3->setApplication($application2);
		
		$image4 = new Image();
		$image4->setUrl("http://www.giornalettismo.com/wp-content/uploads/2012/12/screen-shot-2012-12-12-at-11-13-53-pm-770x310.png");
		$image4->setAlt("Seconde image Street");
		$image4->setApplication($application2);
		
		$customer2->addApplication($application2);
		
		
		$em->persist($customer2);
		$em->persist($application2);
		$em->persist($image3);
		$em->persist($image4);
		
	
		
		
		$customer3 = new Customer();
		$customer3->setCity($villes->findOneByName("Ales"));
		$customer3->setContactFirstName("Alfred");
		$customer3->setContactLastName("Bond");
		$customer3->setContactMail("ab@gmail.com");
		$customer3->setContactPhone("054846655");
		$customer3->setName("Ales Mairie");
		$customer3->setSiret("5665656596");
		
		
		$application3 = new Application();
		$application3->setName('Datacity Datacity Tourism');
		$application3->setUrl("http://www.url-tourism.fr/");
		$application3->setDescription('Application de référencement des principaux lieux touritiques');
		$application3->setCity($villes->findOneByName("Ales"));
		$application3->addCategorie($categories->findOneByName("Tourisme"));
		$application3->addCategorie($categories->findOneByName("Concerts"));
		$application3->addCategorie($categories->findOneByName("Cinémas"));
		$application3->setDownloaded("236");
		$application3->setCustomer($customer3);
		$application3->addPlatform($platforms->findOneByName("iOS"));
		$application3->addPlatform($platforms->findOneByName("Windows Phone"));
		$application3->addPlatform($platforms->findOneByName("Android"));
		
		$image5 = new Image();
		$image5->setUrl("http://fr.rotterdam.info/data/offer/offerid1005/large/City-Racing-Rotterdam---Bavaria-City-Racing-133882027806.jpg");
		$image5->setAlt("Premiere image Tourisme");
		$image5->setApplication($application3);
		
		$image6 = new Image();
		$image6->setUrl("http://wamu.org/sites/wamu.org/files/styles/headline_landscape/public/images/attach/08.02.13news-flickr-ocean-city.jpg?itok=gDxBsSWI");
		$image6->setAlt("Seconde image Tourisme");
		$image6->setApplication($application3);
		
		$customer3->addApplication($application3);
		
		
		
		
		$em->persist($customer3);
		$em->persist($application3);
		$em->persist($image5);
		$em->persist($image6);
		
	
		
		
		$customer4 = new Customer();
		$customer4->setCity($villes->findOneByName("Catalogne (village)"));
		$customer4->setContactFirstName("Cyril");
		$customer4->setContactLastName("Decatalogne");
		$customer4->setContactMail("catalogne.cyril@gmail.com");
		$customer4->setContactPhone("0658797945");
		$customer4->setName("Catalogne (village) Mairie");
		$customer4->setSiret("87945561");
		
		
		$application4 = new Application();
		$application4->setName('Datacity Inch\'Allah');
		$application4->setUrl("http://www.url-inchallah.fr");
		$application4->setDescription('Application de référencement des principaux coins a eviter. <3');
		$application4->setCity($villes->findOneByName("Catalogne (village)"));
		$application4->addCategorie($categories->findOneByName("Évènement"));
		$application4->addCategorie($categories->findOneByName('Itinéraire'));
		$application4->setDownloaded(988465);
		$application4->setCustomer($customer4);
		$application4->addPlatform($platforms->findOneByName("iOS"));
		$application4->addPlatform($platforms->findOneByName("Android"));
		$application4->addPlatform($platforms->findOneByName("Blackberry"));
		
		$image7 = new Image();
		$image7->setUrl("http://us.123rf.com/400wm/400/400/tribalium123/tribalium1231210/tribalium123121000126/15686858-bombe-vieux-commencent-a-exploser-explosion-de-bandes-dessinees-bombe-style-ancien.jpg");
		$image7->setAlt("Premiere image ic");
		$image7->setApplication($application4);
		
		$image8 = new Image();
		$image8->setUrl("http://www.astrosurf.com/luxorion/Physique/bombe-mururoa1.jpg");
		$image8->setAlt("Seconde image ic");
		$image8->setApplication($application4);
		
		$customer4->addApplication($application4);
		
		
		
		
		$em->persist($customer4);
		$em->persist($application4);
		$em->persist($image7);
		$em->persist($image8);
		
		// Création des données News
		$news = new News();
		$news->setTitle('Test1');
		$news->setUser('Cynt');
		$news->setMessage("Message pour l'article numero un");
		$news->setDate("15.08.2013");
		
		$news2 = new News();
		$news2->setTitle('Test2');
		$news2->setUser('Marco');
		$news2->setMessage("Message pour l'article numero deux");
		$news2->setDate("10.07.2013");
		
		$news3 = new News();
		$news3->setTitle('Test3');
		$news3->setUser('Cedric');
		$news3->setMessage("Message pour l'article numero trois");
		$news3->setDate("22.05.2013");
				
	
		$em->persist($news);
		$em->persist($news2);
		$em->persist($news3);
		
		
		$em->flush();
		return ("Initialisation de la DB finie.");
		}
		return ("Les donnees sont deja en base !");
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
