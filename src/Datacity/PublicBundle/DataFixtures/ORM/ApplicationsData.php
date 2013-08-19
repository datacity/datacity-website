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
		$application = new Application();
		$application->setName('Datacity Culture');
		$application->setUrl('http://www.url-culture.fr');
		$application->setDescription('Application de référencement des principaux lieux culturels');
		$application->setCity($this->getReference('city-'.CitiesData::$citiesName[0])); //Paris
		$application->addCategorie($this->getReference('category-'.CategoriesData::$categoriesName[0])); //Culture
		$application->addCategorie($this->getReference('category-'.CategoriesData::$categoriesName[4])); //Concerts
		$application->setDownloaded(6879);
		$application->setCustomer($this->getReference('customer-'.CustomersData::$customersName[0])); //Paris Mairie
		foreach (PlatformsData::$platformName as $name)
		{
			$application->addPlatform($this->getReference('platform-'.$name));
		}
		$manager->persist($application);
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 5;
	}
}