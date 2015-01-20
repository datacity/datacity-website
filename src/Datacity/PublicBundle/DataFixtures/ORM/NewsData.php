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
			$news->setTitle("Bienvenue");
			$news->setMessage("L'équipe DataCity vous souhaite la bienvenue et a le plaisir 
			de vous présenter son site vitrine. Sur notre site vous trouverez une présentation 
			du projet, de l'équipe et des actualités vous informant sur l'avancée du projet. Bonne visite à tous !!");
			$news->setDate(new \DateTime('2013-12-17 17:42:54'));
			$news->setUser($this->getReference("user-marc.soufflet@epitech.eu"));
			$this->addReference("news-". $news->getTitle(), $news);
			$manager->persist($news);

			$news = new News();
			$news->setTitle("L'Equipe en France");
			$news->setMessage("Toute l'équipe de DataCity est de retour en France nous allons pourvoir mettre
			les bouchés double pour livrer une beta au plus tard fin Janvier. Nous vous tiendront informé 
			lorsque la beta sera diposnible, n'hésitez pas à parler de DataCity autour de vous.");
			$news->setDate(new \DateTime('2014-07-01 14:48:42'));
			$news->setUser($this->getReference("user-cyril.morales@epitech.eu"));
			$this->addReference("news-". $news->getTitle(), $news);
			$manager->persist($news);

			$news = new News();
			$news->setTitle("Forum EIP");
			$news->setMessage(" Les vendredi 21 de 14h-18h et samedi 22 Novembre de 9h-17h, venez
			nous rencontrer au forum EIP à l'école d'Epitech Paris. 
			Vous pourrez découvrir le projet DataCity, son équipe ainsi que tous les autres projets
			de notre promotion EPITECH 2015. A cette occasion nous avons réalisé un petit trailer 
			disponible à l'adresse suivante : https://www.youtube.com/watch?v=AdPn544MSIw");
			$news->setDate(new \DateTime('2014-10-12 11:12:44'));
			$news->setImage($this->getReference('image-'.md5(ImagesData::$imagesUrl[14])));
			$news->setUser($this->getReference("user-marquis_c@epitech.eu"));
			$this->addReference("news-". $news->getTitle(), $news);
			$manager->persist($news);

			$news = new News();
			$news->setTitle("Beta bientôt disponible");
			$news->setMessage(" Une beta de Datacity sera bientôt disponible, en effet notre API est presque 
			terminée, quant au site web nous sommes à 85% du développement. Nous n'avons pas de date précise 
			mais la beta devrait être disponible fin Janvier début Février. L'équipe DataCity vous souhaite 
			de passer de bonnes fêtes de fin d'année.");
			$news->setDate(new \DateTime('2014-12-18 18:31:22'));
			$news->setUser($this->getReference("user-hamsou_l@epitech.eu"));
			$this->addReference("news-". $news->getTitle(), $news);
			$manager->persist($news);

			

			
		$manager->flush();
	}
	
	// Exécution de la fixture aprés l'éxécution des 6 autres.
	public function getOrder()
	{
		return 8;
	}
}