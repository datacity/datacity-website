<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\City;

class CitiesData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $citiesName = array(
			'Paris',
			'Montpellier',
			'Ales',
			'Catalogne (village)',
			'Nimes',
			'Lyon' 
	);
	
	public function load(ObjectManager $manager)
	{
		foreach (self::$citiesName as $i => $name)
		{
			$city = new City();
			$city->setName($name);
			$manager->persist($city);
			$this->addReference('city-'.$name, $city);
		}
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 3;
	}
}