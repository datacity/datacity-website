<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\DataColumnsType;

//Hey ! Too much Data here !
class DataColumnsTypeData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $dataColumnsTypeName = array (
			'GeoPoint',
			'Texte',
			'Nombre',
			'Date',
			'Argent',
			'Adresse',
			'Telephone',
			'Mail'
	);
	
	public function load(ObjectManager $manager)
	{
		foreach (self::$dataColumnsTypeName as $i => $name)
		{
			$data = new DataColumnsType();
			$data->setName($name);
			$manager->persist($data);
			$this->addReference('datacolumnstype-'.$name, $data);
    	}
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 13;
	}
}
