<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\News;

class NewsData extends AbstractFixture implements OrderedFixtureInterface
{
	// Créaton d'utilisateurs pour la news
	static public $customer = array(
			'Cyntia',
			'Marc',
			'Cedric'
	);
	
	public function load(ObjectManager $manager)
	{
		// Création de titres pour la news
		$title = array (
				'Titre 1',
				'Titre 2',
				'Titre 3'
		);
		
		// Création de messages pour la news
		$message =  array (
			'Message 1',
			'Message 2',
			'Message 3'
		);
		
		//Création de dates pour la news
		$date =  array (
			'21.09.2013',
			'08.10.2013',
			'16.11.2013'
		);
		//Création d'URL d'image pour la news
		$img =  array (
				'http://www.businesscomputingworld.co.uk/wp-content/uploads/2012/08/Cool-City.jpg',
				'http://senseable.mit.edu/copenhagenwheel/pix_urbanData/data_02.jpg',
				'http://www.clandoustphotography.co.uk/images/banner_bridges1.jpg'
		);
		
		// Construction de 3 objets news avec les données des tableaux crées au dessus
		foreach (self::$customer as $i => $cust)
		{
			$news = new News();
			$news->setUser($cust);
			$news->setTitle($title[$i]);
			$news->setMessage($message[$i]);
			$news->setDate($date[$i]);
			$news->setImg($img[$i]);
			$manager->persist($news);
			$this->addReference('news-'.$cust, $news);
		}
		// Insertion des objet news en base
		$manager->flush();
	}
	
	// Exécution de la fixture aprés l'éxécution des 6 autres.
	public function getOrder()
	{
		return 7;
	}
}