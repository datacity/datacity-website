<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Customer;

class CustomersData extends AbstractFixture implements OrderedFixtureInterface
{
	static public $customersName = array (
			'Paris Mairie',
			'Montpellier Mairie',
			'Ales Mairie',
			'Catalogne (village) Mairie'
	);
	
	public function load(ObjectManager $manager)
	{
		$cfn = array (
				'Pierro',
				'Francois',
				'Alfred',
				'Cyril'
		);
		$cln = array (
				'Samsoul',
				'Dujardin',
				'Bond',
				'Decatalogne'
		);
		$cm = array (
				'lionel.samsoul@gmail.com',
				'pierrodujardin@gmail.com',
				'ab@gmail.com',
				'catalogne.cyril@gmail.com'
		);
		$cp = array (
				'0605075855',
				'032423123445',
				'054846655',
				'0658797945'
		);
		$s = array (
				'878932645',
				'23231313231',
				'5665656596',
				'87945561'
		);
		foreach (self::$customersName as $i => $name)
		{
			$customer = new Customer();
			$customer->setCity($this->getReference('city-'.CitiesData::$citiesName[$i]));
			$customer->setName($name);
			$customer->setContactFirstName($cfn[$i]);
			$customer->setContactLastName($cln[$i]);
			$customer->setContactMail($cm[$i]);
			$customer->setContactPhone($cp[$i]);
			$customer->setSiret($s[$i]);
			$manager->persist($customer);
			$this->addReference('customer-'.$name, $customer);
		}
		$manager->flush();
	}
	
	public function getOrder()
	{
		return 4;
	}
}
