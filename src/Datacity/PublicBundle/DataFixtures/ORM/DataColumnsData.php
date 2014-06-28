<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\DataColumns;

//Hey ! Too much Data here again !
class DataColumnsData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		//Concerts en France
		$data = new DataColumns();
		$data->setName('Position');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[0])); //GeoPoint
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Nom');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[1])); //Texte
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Nombre de parcipants');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Date');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[3])); //Date
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Adresse');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[4])); //Adresse
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);
		$data = new DataColumns();
		$data->setName('Durée en jours');
		$data->setType($this->getReference('datacolumnstype-' . DataColumnsTypeData::$dataColumnsTypeName[2])); //Nombre
		$data->setDataset($this->getReference('dataset-1'));
		$manager->persist($data);
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 15;
	}
}
