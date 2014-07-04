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
		$image = array (
				$this->getReference('image-' . md5(ImagesData::$imagesUrl[8])),
				$this->getReference('image-' . md5(ImagesData::$imagesUrl[9])),
				$this->getReference('image-' . md5(ImagesData::$imagesUrl[10])),
				$this->getReference('image-' . md5(ImagesData::$imagesUrl[11])),
		);

		$link = array (
			'http://www.data.gouv.fr/',
			'http://opendata.montpelliernumerique.fr/',
			'http://datarmor.cotesdarmor.fr/',
			'http://www.datacity.fr/'
		);

		foreach (self::$prodName as $i => $name)
		{
			$prod = new Producer();
			$prod->setName($name);
			$prod->setDescription('TODO');
			$prod->setImage($image[$i]);
			$prod->setLink($link[$i]);
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
