<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\DSource;

class DSourceData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		//Concerts en France
		$source = new DSource();
		$source->setTitle('Source1');
		$source->setSid('1');
		$source->setSize(3.1);
		$source->setDownloadNb(132);
		$source->setUsefulNb(5);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[3])); //Mensuelle
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[0])); //Paris
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commnune
		$source->setCreator($this->getReference("user-marc.soufflet@epitech.eu"));
		$source->setDataset($this->getReference("dataset-1"));
		$manager->persist($source);
		$source = new DSource();
		$source->setTitle('Source2');
		$source->setSid('2');
		$source->setSize(2.1);
		$source->setDownloadNb(54);
		$source->setUsefulNb(1);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[3])); //Mensuelle
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[1])); //Montpellier
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commnune
		$source->setCreator($this->getReference("user-marquis_c@epitech.eu"));
		$source->setDataset($this->getReference("dataset-1"));
		$manager->persist($source);
		$source = new DSource();
		$source->setTitle('Source3');
		$source->setSid('3');
		$source->setSize(1.5);
		$source->setDownloadNb(34);
		$source->setUsefulNb(3);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[3])); //Mensuelle
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[2])); //Toulouse
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commnune
		$source->setCreator($this->getReference("user-marc.soufflet@epitech.eu"));
		$source->setDataset($this->getReference("dataset-1"));
		$manager->persist($source);
		$source = new DSource();
		$source->setTitle('Source4');
		$source->setSid('4');
		$source->setSize(0.8);
		$source->setDownloadNb(10);
		$source->setUsefulNb(1);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[3])); //Mensuelle
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[3])); //Bordeaux
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commnune
		$source->setCreator($this->getReference("user-marc.soufflet@epitech.eu"));
		$source->setDataset($this->getReference("dataset-1"));
		$manager->persist($source);

		$manager->flush();
	}
	
	public function getOrder()
	{
		return 16;
	}
}
