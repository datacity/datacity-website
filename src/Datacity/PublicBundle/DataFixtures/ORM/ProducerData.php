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

		$description = array (
			'La plateforme “data.gouv.fr” permet aux services publics de publier des données 
			 publiques et à la société civile de les enrichir, modifier, interpréter en vue de 
			 coproduire des informations d’intérêt général.',
			'A travers ce site, la Ville de Montpellier et ses partenaires mettent à disposition 
			 des données publiques non nominatives ayant une dimension territoriale.',
			'Le projet est porté par le Conseil général des Côtes d\'Armor et par ses partenaires : 
			 Saint-Brieuc Agglomération, Côtes d\'Armor Développement... Désormais, aux collectivités 
			 et à chacun de se l\'approprier !',
			'Datacity est un projet qui offre plusieurs fonctionnalités dans le domaine de l\'Open Data. 
			 Il analyse et centralise les besoins des collectivités territoriales grâce à l\'exploitation
			 de données libres, et les met à disposition par une interface de programmation (API). 
			 DataCity offre également un portail applicatif extensible et malléable à la demande des services publics'
		);

		foreach (self::$prodName as $i => $name)
		{
			$prod = new Producer();
			$prod->setName($name);
			$prod->setDescription($description[$i]);
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
