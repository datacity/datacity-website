<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\CoverageTerritory;

class CoverageTerritoryData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $ctName = array (
			'Commune',
			'Département',
			'Région',
			'Pays',
			'Monde'
	);
	
	public function load(ObjectManager $manager)
	{
		foreach (self::$ctName as $i => $name)
		{
			$ct = new CoverageTerritory();
			$ct->setName($name);
			$ct->setLevel($i);
			$manager->persist($ct);
			$this->addReference('coverageterritory-'.$name, $ct);
    	}
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 10;
	}
}
