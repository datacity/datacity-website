<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\News;
use Datacity\UserBundle\Entity\User;
use DateTime;

class NewsData extends AbstractFixture implements OrderedFixtureInterface
{
			

	public function load(ObjectManager $manager)
	{
		
		
		// Construction de 3 objets news 
		
			$news = new News();
			$news->setTitle("Titre1");
			$news->setMessage("Message1");
			$news->setDate(new \DateTime('now'));
			$news->setImg("http://www.businesscomputingworld.co.uk/wp-content/uploads/2012/08/Cool-City.jpg");
			$this->addReference("news-". $news->getTitle(), $news);
			$manager->persist($news);

			$news = new News();
			$news->setTitle("Titre2");
			$news->setMessage("Message2");
			$news->setDate(new \DateTime('now'));
			$news->setImg("http://senseable.mit.edu/copenhagenwheel/pix_urbanData/data_02.jpg");
			$this->addReference("news-". $news->getTitle(), $news);
			$manager->persist($news);

			$news = new News();
			$news->setTitle("Titre3");
			$news->setMessage("Message3");
			$news->setDate(new \DateTime('now'));
			$news->setImg("http://fr.rotterdam.info/data/offer/offerid1005/large/City-Racing-Rotterdam---Bavaria-City-Racing-133882027806.jpg");
			$this->addReference("news-". $news->getTitle(), $news);
			$manager->persist($news);

		$manager->flush();
	}
	
	// Exécution de la fixture aprés l'éxécution des 6 autres.
	public function getOrder()
	{
		return 7;
	}
}