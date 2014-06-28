<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Dataset;

class DatasetData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$dataset = new Dataset();
		$dataset->setTitle('Concerts en France'); //I have no idea
		$dataset->setDid('1');
		$dataset->setDescription('Pellentesque vel auctor nisl. Integer cursus quam quam, ut cursus urna eleifend vel. Integer dictum, sem eu dapibus mollis, enim augue pulvinar magna, vel eleifend arcu neque eu ligula. Etiam molestie lacus quis tortor vestibulum, eget iaculis velit hendrerit. Aenean vitae mi faucibus, vehicula tortor a, scelerisque sem. Nullam molestie auctor justo, in euismod eros ullamcorper in. Suspendisse vel diam tellus. In at rutrum mi. Curabitur fermentum orci ac bibendum tristique. Cras tempor sem eu egestas tristique. Etiam consectetur imperdiet tortor, a dictum arcu congue a. Vestibulum tristique vestibulum leo, vel tempor orci. Phasellus ullamcorper mattis diam.');
		$dataset->setLink('http://www.example.com');
		$dataset->setVisitedNb(300);
		$dataset->setUsefulNb(42);
		$dataset->setUndesirableNb(0);
		$dataset->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[3])); //Mensuelle
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[0])); //Paris
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[1])); //Montpellier
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[2])); //Toulouse
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[3])); //Bordeaux
		$dataset->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commnune
		$dataset->setCreator($this->getReference("user-marc.soufflet@epitech.eu"));
		$dataset->addContributor($this->getReference("user-marquis_c@epitech.eu"));
		$dataset->setCategory($this->getReference('category-' . CategoriesData::$categoriesName[0])); //Culture
		$dataset->addTag($this->getReference('tag-' . TagData::$tagName[0])); //Musique
		$dataset->addTag($this->getReference('tag-' . TagData::$tagName[8])); //Evénement
		$dataset->setLicense($this->getReference('license-' . LicenseData::$licenseName[0])); //Licence Ouverte
		$manager->persist($dataset);
		$this->addReference("dataset-". $dataset->getDid(), $dataset);

		$manager->flush();
	}
	
	public function getOrder()
	{
		return 14;
	}
}
