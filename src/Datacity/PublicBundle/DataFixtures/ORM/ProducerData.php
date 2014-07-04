<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Producer;

class ProducerData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $prodName = array (
			'data.gouv.fr',
			'Territoire Montpellier Numérique',
			'Dat\'Armor',
			'Datacity'
	);
	
	public function load(ObjectManager $manager)
	{
		foreach (self::$prodName as $i => $name)
		{
			$prod = new Producer();
			$prod->setName($name);
			$prod->setDescription('TODO');
			$manager->persist($prod);
			$this->addReference('producer-'.$name, $prod);
    	}
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 14;
	}
}
