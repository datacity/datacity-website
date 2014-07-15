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
		$source->setDownloadNb(132);
		$source->setUsefulNb(5);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[3])); //Mensuelle
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[0])); //Paris
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commune
		$source->setCreator($this->getReference("user-marc.soufflet@epitech.eu"));
		$source->setDataset($this->getReference("dataset-1"));
		$source->setProducer($this->getReference('producer-' . ProducerData::$prodName[3])); //Datacity
		$manager->persist($source);
		$source = new DSource();
		$source->setTitle('Source2');
		$source->setDownloadNb(54);
		$source->setUsefulNb(1);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[3])); //Mensuelle
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[1])); //Montpellier
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commune
		$source->setCreator($this->getReference("user-marquis_c@epitech.eu"));
		$source->setDataset($this->getReference("dataset-1"));
		$source->setProducer($this->getReference('producer-' . ProducerData::$prodName[3])); //Datacity
		$manager->persist($source);
		$source = new DSource();
		$source->setTitle('Source3');
		$source->setDownloadNb(34);
		$source->setUsefulNb(3);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[3])); //Mensuelle
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[2])); //Toulouse
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commune
		$source->setCreator($this->getReference("user-marc.soufflet@epitech.eu"));
		$source->setDataset($this->getReference("dataset-1"));
		$source->setProducer($this->getReference('producer-' . ProducerData::$prodName[3])); //Datacity
		$manager->persist($source);
		$source = new DSource();
		$source->setTitle('Source4');
		$source->setDownloadNb(10);
		$source->setUsefulNb(1);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[3])); //Mensuelle
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[3])); //Bordeaux
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commune
		$source->setCreator($this->getReference("user-marc.soufflet@epitech.eu"));
		$source->setDataset($this->getReference("dataset-1"));
		$source->setProducer($this->getReference('producer-' . ProducerData::$prodName[3])); //Datacity
		$manager->persist($source);

		//Batiments non résidentiels
		$source = new DSource();
		$source->setTitle('Bâtiments de Montpellier');
		$source->setDownloadNb(324);
		$source->setUsefulNb(200);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[4])); //Annuelle
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[1])); //Montpellier
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commnune
		$source->setCreator($this->getReference("user-admin@datacity.fr"));
		$source->setDataset($this->getReference("dataset-2"));
		$source->setLink('http://opendata.montpelliernumerique.fr/Batiments');
		$source->setProducer($this->getReference('producer-' . ProducerData::$prodName[1])); //Territoire Montpellier Numérique
		$manager->persist($source);

		//Résultats des élections européennes
		$source = new DSource();
		$source->setTitle('Résultats des élections européennes de Montpellier');
		$source->setDownloadNb(231);
		$source->setUsefulNb(124);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[4])); //Annuelle
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[1])); //Montpellier
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[0])); //Commnune
		$source->setCreator($this->getReference("user-admin@datacity.fr"));
		$source->setDataset($this->getReference("dataset-3"));
		$source->setLink('http://opendata.montpelliernumerique.fr/Resultats-des-elections-135');
		$source->setProducer($this->getReference('producer-' . ProducerData::$prodName[1])); //Territoire Montpellier Numérique
		$manager->persist($source);

		//Omnis iste
		$source = new DSource();
		$source->setTitle('Praesent euismod');
		$source->setDownloadNb(12);
		$source->setUsefulNb(0);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[1])); //Quotidienne
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[7])); //France
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[3])); //Pays
		$source->setCreator($this->getReference("user-admin@datacity.fr"));
		$source->setDataset($this->getReference("dataset-4"));
		$source->setLink('http://www.example.com');
		$source->setProducer($this->getReference('producer-' . ProducerData::$prodName[3])); //Datacity
		$manager->persist($source);
		$source = new DSource();
		$source->setTitle('Aenean molestie');
		$source->setDownloadNb(15);
		$source->setUsefulNb(1);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[1])); //Quotidienne
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[8])); //Canada
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[3])); //Pays
		$source->setCreator($this->getReference("user-admin@datacity.fr"));
		$source->setDataset($this->getReference("dataset-4"));
		$source->setLink('http://www.example.com');
		$source->setProducer($this->getReference('producer-' . ProducerData::$prodName[3])); //Datacity
		$manager->persist($source);
		$source = new DSource();
		$source->setTitle('Sed eu leo sed');
		$source->setDownloadNb(23);
		$source->setUsefulNb(2);
		$source->setUndesirableNb(0);
		$source->setFrequency($this->getReference('frequency-' . FrequencyData::$frequencyName[1])); //Quotidienne
		$source->setPlace($this->getReference('place-' . PlaceData::$placeName[9])); //Allemagne
		$source->setCoverageTerritory($this->getReference('coverageterritory-' . CoverageTerritoryData::$ctName[3])); //Pays
		$source->setCreator($this->getReference("user-admin@datacity.fr"));
		$source->setDataset($this->getReference("dataset-4"));
		$source->setLink('http://www.example.com');
		$source->setProducer($this->getReference('producer-' . ProducerData::$prodName[3])); //Datacity
		$manager->persist($source);

		$manager->flush();
	}

	public function getOrder()
	{
		return 17;
	}
}
