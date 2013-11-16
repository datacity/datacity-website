<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\News;

class NewsData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $customer = array(
			'Cyntia',
			'Marc',
			'Cedric'
	);
	
	public function load(ObjectManager $manager)
	{
		$title = array (
				'Titre 1',
				'Titre 2',
				'Titre 3'
		);
		$message =  array (
			'Message 1',
			'Message 2',
			'Message 3'
		);
		$date =  array (
			'21.09.2013',
			'08.10.2013',
			'16.11.2013'
		);
		
		$img =  array (
				'http://www.businesscomputingworld.co.uk/wp-content/uploads/2012/08/Cool-City.jpg',
				'http://senseable.mit.edu/copenhagenwheel/pix_urbanData/data_02.jpg',
				'http://www.clandoustphotography.co.uk/images/banner_bridges1.jpg'
		);
		
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
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 7;
	}
}