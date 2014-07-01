<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\License;

class LicenseData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $licenseName = array (
			'Licence Ouverte',
			'Licence2',
			'Licence3',
			'Licence4'
	);
	
	public function load(ObjectManager $manager)
	{
		$openlicense = <<<'EOD'
		  Dans le cadre de la politique du Gouvernement en faveur de l’ouverture des données publiques (« Open Data »), Etalab a conçu la « Licence Ouverte / Open Licence ». Cette licence, élaborée en concertation avec l’ensemble des acteurs concernés, facilite et encourage la réutilisation des données publiques mises à disposition gratuitement. Depuis novembre 2011, la "Licence Ouverte / Open Licence" s'applique à l'ensemble des réutilisations libres gratuites de données publiques issues des administrations de l'Etat et de ses établissements publics administratifs, à l'exclusion de tout autre licence.

La « Licence Ouverte / Open Licence » présente les caractéristiques suivantes :

1. Une grande liberté de réutilisation des informations :

- Une licence ouverte, libre et gratuite, qui apporte la sécurité juridique nécessaire aux producteurs et aux réutilisateurs des données publiques ;

- Une licence qui promeut la réutilisation la plus large en autorisant la reproduction, la redistribution, l’adaptation et l’exploitation commerciale des données ;

- Une licence qui s’inscrit dans un contexte international en étant compatible avec les standards des licences Open Data développées à l’étranger et notamment celles du gouvernement britannique (Open Government Licence) ainsi que les autres standards internationaux (ODC-BY, CC-BY 2.0).

2. Une exigence forte de transparence de la donnée et de qualité des sources en rendant obligatoire la mention de la paternité.

3. Une opportunité de mutualisation pour les autres données publiques en mettant en place un standard réutilisable par les collectivités territoriales qui souhaiteraient se lancer dans l’ouverture des données publiques.
EOD;
		$desc = array (
			$openlicense,
			'desc2',
			'desc3',
			'desc4',
		);

		$link = array (
			'http://www.etalab.gouv.fr/pages/licence-ouverte-open-licence-5899923.html',
			'http://www.example.com/',
			'http://www.example.com/',
			'http://www.example.com/'
		);
		foreach (self::$licenseName as $i => $name)
		{
			$license = new License();
			$license->setName($name); 
			$license->setDescription($desc[$i]);
			$license->setLink($link[$i]);
			$manager->persist($license);
			$this->addReference('license-'.$name, $license);
    	}
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 11;
	}
}
