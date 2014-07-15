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
		$dataset->setDescription('Pellentesque vel auctor nisl. Integer cursus quam quam, ut cursus urna eleifend vel. Integer dictum, sem eu dapibus mollis, enim augue pulvinar magna, vel eleifend arcu neque eu ligula. Etiam molestie lacus quis tortor vestibulum, eget iaculis velit hendrerit. Aenean vitae mi faucibus, vehicula tortor a, scelerisque sem. Nullam molestie auctor justo, in euismod eros ullamcorper in. Suspendisse vel diam tellus. In at rutrum mi. Curabitur fermentum orci ac bibendum tristique. Cras tempor sem eu egestas tristique. Etiam consectetur imperdiet tortor, a dictum arcu congue a. Vestibulum tristique vestibulum leo, vel tempor orci. Phasellus ullamcorper mattis diam.');
		$dataset->setVisitedNb(300);
		$dataset->setUsefulNb(42);
		$dataset->setUndesirableNb(0);
		$dataset->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[3])); //Mensuelle
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[0])); //Paris
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[1])); //Montpellier
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[2])); //Toulouse
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[3])); //Bordeaux
		$dataset->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commune
		$dataset->setCreator($this->getReference("user-marc.soufflet@epitech.eu"));
		$dataset->addContributor($this->getReference("user-marquis_c@epitech.eu"));
		$dataset->addCategory($this->getReference('category-' . CategoriesData::$categoriesName[0])); //Culture
		$dataset->addTag($this->getReference('tag-' . TagData::$tagName[0])); //Musique
		$dataset->addTag($this->getReference('tag-' . TagData::$tagName[8])); //Evénement
		$dataset->setLicense($this->getReference('license-' . LicenseData::$licenseName[0])); //Licence Ouverte
		$manager->persist($dataset);
		$this->addReference("dataset-1", $dataset);

		$dataset = new Dataset();
		$dataset->setTitle('Batiments non résidentiels');
		$dataset->setDescription('Cette donnée spatiale renseigne l’emplacement de l’ensemble des bâtiments non résidentiels. Il s’agit à la fois de bâtiments publics, mais aussi certaines constructions privées comme les églises.');
		$dataset->setVisitedNb(500);
		$dataset->setUsefulNb(242);
		$dataset->setUndesirableNb(0);
		$dataset->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[4])); //Annuelle
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[1])); //Montpellier
		$dataset->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commune
		$dataset->setCreator($this->getReference("user-admin@datacity.fr"));
		$dataset->addCategory($this->getReference('category-' . CategoriesData::$categoriesName[4])); //Société
		$dataset->addTag($this->getReference('tag-' . TagData::$tagName[1])); //Service public
		$dataset->setLicense($this->getReference('license-' . LicenseData::$licenseName[0])); //Licence Ouverte
		$manager->persist($dataset);
		$this->addReference("dataset-2", $dataset);

		$dataset = new Dataset();
		$dataset->setTitle('Résultats des élections européennes');
		$dataset->setDescription('Cette donnée renseigne les résultats des élections européennes par bureau de vote pour le premier tour.');
		$dataset->setVisitedNb(823);
		$dataset->setUsefulNb(456);
		$dataset->setUndesirableNb(0);
		$dataset->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[4])); //Annuelle
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[1])); //Montpellier
		$dataset->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commune
		$dataset->setCreator($this->getReference("user-admin@datacity.fr"));
		$dataset->addCategory($this->getReference('category-' . CategoriesData::$categoriesName[4])); //Société
		$dataset->addTag($this->getReference('tag-' . TagData::$tagName[6])); //Politique
		$dataset->setLicense($this->getReference('license-' . LicenseData::$licenseName[0])); //Licence Ouverte
		$manager->persist($dataset);
		$this->addReference("dataset-3", $dataset);

		$dataset = new Dataset();
		$dataset->setTitle('Omnis iste');
		$dataset->setDescription('Sed eu leo sed purus tempus tincidunt id a dui. Duis volutpat eros nec ipsum rutrum vehicula. Proin viverra elit non sodales lobortis. Pellentesque vitae felis ac ligula pharetra laoreet non et dui. In nec eros nec mi egestas hendrerit. Nulla facilisi. Quisque scelerisque tortor non urna tempus, nec sagittis ligula rutrum. Aliquam rutrum id felis in interdum. Morbi consectetur urna nec est convallis, ut ornare leo cursus. Curabitur nec nulla sed magna bibendum hendrerit. Proin est sapien, condimentum at sagittis id, pharetra sit amet lectus. Nunc in molestie odio.');
		$dataset->setVisitedNb(354);
		$dataset->setUsefulNb(2);
		$dataset->setUndesirableNb(0);
		$dataset->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[1])); //Quotidienne
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[7])); //France
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[8])); //Canada
		$dataset->addPlace($this->getReference('place-' . PlaceData::$placeName[9])); //Allemagne
		$dataset->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[3])); //Pays
		$dataset->setCreator($this->getReference("user-admin@datacity.fr"));
		$dataset->addCategory($this->getReference('category-' . CategoriesData::$categoriesName[2])); //Transports
		$dataset->addTag($this->getReference('tag-' . TagData::$tagName[1])); //Service public
		$dataset->addTag($this->getReference('tag-' . TagData::$tagName[2])); //Vélo
		$dataset->addTag($this->getReference('tag-' . TagData::$tagName[3])); //Voiture
		$dataset->setLicense($this->getReference('license-' . LicenseData::$licenseName[1])); //Licence2
		$manager->persist($dataset);
		$this->addReference("dataset-4", $dataset);

		$manager->flush();
	}

	public function getOrder()
	{
		return 15;
	}
}
