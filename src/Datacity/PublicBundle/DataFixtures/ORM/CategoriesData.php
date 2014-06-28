<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Category;

class CategoriesData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $categoriesName = array (
			'Culture',
			'Santé',
			'Transports',
			'Alimentation',
			'Société',
			'Economie',
			'Logement'
	);
	
	public function load(ObjectManager $manager)
	{
		foreach (self::$categoriesName as $i => $name)
		{
			$cat = new Category();
			$cat->setName($name); 
			$manager->persist($cat);
			$this->getReference('image-'.md5(ImagesData::$imagesUrl[$i]))->setCategory($cat);
			$this->addReference('category-'.$name, $cat);
    	}
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 1;
	}
}
