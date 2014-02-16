<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Application;

class ApplicationsData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		//for ($i = 10; $i > 0; $i--) {
			$application = new Application();
			$application->setName('Datacity Culture');
			$application->setUrl('http://www.url-culture.fr');
			$application->setDescription('Application de référencement des principaux lieux culturels');
			$application->setCity($this->getReference('city-'.CitiesData::$citiesName[0])); //Paris
			$application->addCategorie($this->getReference('category-'.CategoriesData::$categoriesName[0])); //Culture
			$application->addCategorie($this->getReference('category-'.CategoriesData::$categoriesName[4])); //Concerts
			$application->setDownloaded(6879);
			$this->getReference('image-'.md5(ImagesData::$imagesUrl[0]))->addApplication($application);
			$this->getReference('image-'.md5(ImagesData::$imagesUrl[1]))->addApplication($application);
			foreach (PlatformsData::$platformName as $name)
			{
				$application->addPlatform($this->getReference('platform-'.$name));
			}
			$this->addReference("application-". $application->getName(), $application);
			$manager->persist($application);
		
		$application = new Application();
		$application->setName('Datacity Street');
		$application->setUrl("http://www.url-street.fr/");
		$application->setDescription('Application de référencement des principales rues. ^^');
		$application->setCity($this->getReference('city-'.CitiesData::$citiesName[1])); //Montpellier
		$application->addCategorie($this->getReference('category-'.CategoriesData::$categoriesName[0])); //Culture
		$application->addCategorie($this->getReference('category-'.CategoriesData::$categoriesName[2])); //Tourisme
		$application->setDownloaded(434);
		$application->addPlatform($this->getReference('platform-'.PlatformsData::$platformName[0])); //iOS
		$application->addPlatform($this->getReference('platform-'.PlatformsData::$platformName[3])); //Blackberry
		$this->getReference('image-'.md5(ImagesData::$imagesUrl[2]))->addApplication($application);
		$this->getReference('image-'.md5(ImagesData::$imagesUrl[3]))->addApplication($application);
		$this->addReference("application-". $application->getName(), $application);
		$manager->persist($application);
		
		$application = new Application();
		$application->setName('Datacity Tourism');
		$application->setUrl("http://www.url-tourism.fr/");
		$application->setDescription('Application de référencement des principaux lieux touritiques');
		$application->setCity($this->getReference('city-'.CitiesData::$citiesName[2])); //Ales
		$application->addCategorie($this->getReference('category-'.CategoriesData::$categoriesName[2])); //Tourisme
		$application->addCategorie($this->getReference('category-'.CategoriesData::$categoriesName[4])); //Concerts
		$application->addCategorie($this->getReference('category-'.CategoriesData::$categoriesName[6])); //Cinémas
		$application->setDownloaded(236);
		$application->addPlatform($this->getReference('platform-'.PlatformsData::$platformName[0])); //iOS
		$application->addPlatform($this->getReference('platform-'.PlatformsData::$platformName[1])); //Android
		$application->addPlatform($this->getReference('platform-'.PlatformsData::$platformName[2])); //Windows Phone
		$this->getReference('image-'.md5(ImagesData::$imagesUrl[4]))->addApplication($application);
		$this->getReference('image-'.md5(ImagesData::$imagesUrl[5]))->addApplication($application);
		$this->addReference("application-". $application->getName(), $application);
		$manager->persist($application);
		
		$application = new Application();
		$application->setName('Datacity Fiction');
		$application->setUrl("http://www.url-fiction.fr");
		$application->setDescription('Application fictive');
		$application->setCity($this->getReference('city-'.CitiesData::$citiesName[3])); //Catalogne (village)
		$application->addCategorie($this->getReference('category-'.CategoriesData::$categoriesName[3])); //Évènement
		$application->addCategorie($this->getReference('category-'.CategoriesData::$categoriesName[1])); //Itinéraire
		$application->setDownloaded(988465);
		$application->addPlatform($this->getReference('platform-'.PlatformsData::$platformName[0])); //iOS
		$application->addPlatform($this->getReference('platform-'.PlatformsData::$platformName[1])); //Android
		$application->addPlatform($this->getReference('platform-'.PlatformsData::$platformName[3])); //Blackberry
		$this->getReference('image-'.md5(ImagesData::$imagesUrl[6]))->addApplication($application);
		$this->getReference('image-'.md5(ImagesData::$imagesUrl[7]))->addApplication($application);
		$this->addReference("application-". $application->getName(), $application);
		$manager->persist($application);
		//}
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 6;
	}
}