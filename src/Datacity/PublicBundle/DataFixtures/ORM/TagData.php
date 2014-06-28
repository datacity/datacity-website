<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Tag;

class TagData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $tagName = array (
			'Musique',
			'Service public',
			'Vélo',
			'Voiture',
			'Train',
			'Hôtel',
			'Politique',
			'Tag8',
			'Evénement'
	);
	
	public function load(ObjectManager $manager)
	{
		foreach (self::$tagName as $i => $name)
		{
			$tag = new Tag();
			$tag->setName($name);
			$manager->persist($tag);
			$this->addReference('tag-'.$name, $tag);
    	}
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 12;
	}
}
