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
		$application->setName('ERP Montpellier');
		$application->setUrl("http://www.erp-montpellier.fr/");
		$application->setDescription('Référencement des etablissements recevant du public de la Ville de Montpellier');
		$application->setCity($this->getReference('city-'.CitiesData::$citiesName[1])); //Montpellier
		$application->addCategory($this->getReference('category-'.CategoriesData::$categoriesName[0])); //Culture
		$application->addCategory($this->getReference('category-'.CategoriesData::$categoriesName[2])); //Tourisme
		$application->setDownloaded(434);
		$application->addPlatform($this->getReference('platform-'.PlatformsData::$platformName[0])); //iOS
		$application->addPlatform($this->getReference('platform-'.PlatformsData::$platformName[1])); //Android
		$application->addPlatform($this->getReference('platform-'.PlatformsData::$platformName[3])); //Blackberry
		$application->addImage($this->getReference('image-'.md5(ImagesData::$imagesUrl[2])));
		$application->addImage($this->getReference('image-'.md5(ImagesData::$imagesUrl[3])));
		$this->addReference("application-". $application->getName(), $application);
		$manager->persist($application);

		$manager->flush();
	}
	
	public function getOrder()
	{
		return 6;
	}
}