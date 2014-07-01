<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Frequency;

class FrequencyData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $frequencyName = array (
			'Temps réel',
			'Quotidienne',
			'Hebdomadaire',
			'Mensuelle',
			'Annuelle'
	);
	
	public function load(ObjectManager $manager)
	{
		foreach (self::$frequencyName as $i => $name)
		{
			$freq = new Frequency();
			$freq->setName($name);
			$freq->setIcon('icon-'.$i); 
			$freq->setLevel($i);
			$manager->persist($freq);
			$this->addReference('frequency-'.$name, $freq);
    	}
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 8;
	}
}
