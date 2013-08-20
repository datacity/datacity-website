<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Platform;

class PlatformsData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $platformName = array(
			'iOS',
			'Android',
			'Windows Phone',
			'Blackberry'
	);
	
	public function load(ObjectManager $manager)
	{
		$versions = array (
				'7.0',
				'4.3',
				'7.8',
				'7.1'
		);
		foreach (self::$platformName as $i => $name)
		{
			$plat = new Platform();
			$plat->setName($name);
			$plat->setVersion($versions[$i]);
			$manager->persist($plat);
			$this->addReference('platform-'.$name, $plat);
		}
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 2;
	}
}