<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Place;

class PlaceData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $placeName = array (
			'Paris',
			'Montpellier',
			'Toulouse',
			'Bordeaux',
			'Nantes',
			'Midi-Pyrénées',
			'Languedoc-Roussillon',
			'France',
			'Canada',
			'Allemagne'
	);
	
	public function load(ObjectManager $manager)
	{
		foreach (self::$placeName as $i => $name)
		{
			$place = new Place();
			$place->setName($name); 
			$manager->persist($place);
			$this->addReference('place-'.$name, $place);
    	}
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 9;
	}
}
