<?php

namespace Datacity\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PublicBundle\Entity\Application;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Datacity\PublicBundle\DataFixtures\ORM\ApplicationsData;
use Datacity\PublicBundle\DataFixtures\ORM\CitiesData;
use Symfony\Component\Security\Core\Util\SecureRandom;

class UsersData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * {@inheritDoc}
	 */
	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;
	}


	public function load(ObjectManager $manager)
	{
		$userManager = $this->container->get('fos_user.user_manager');
		$generator = new SecureRandom();

		$userAdmin = $userManager->createUser();
		$userAdmin->setUsername('Marc');
		$userAdmin->setFirstName('Marc');
		$userAdmin->setLastName('Soufflet');
		$userAdmin->setPlainPassword('marcAdmin');
		$userAdmin->setEnabled(true);
		$userAdmin->setEmail('marc.soufflet@epitech.eu');
		$userAdmin->setCity($this->getReference("city-Montpellier"));
		$userAdmin->setSuperAdmin(true);
		$userAdmin->genPublicKey($generator);
		$userAdmin->genPrivateKey($generator);
		$userManager->updateUser($userAdmin);
		$this->addReference("user-". $userAdmin->getEmail(), $userAdmin);

		$userAdmin = $userManager->createUser();
		$userAdmin->setUsername('Cyntia');
		$userAdmin->setFirstName('Cyntia');
		$userAdmin->setLastName('Marquis');
		$userAdmin->setPlainPassword('cyntiaAdmin');
		$userAdmin->setEnabled(true);
		$userAdmin->setEmail('marquis_c@epitech.eu');
		$userAdmin->setCity($this->getReference("city-Montpellier"));
		$userAdmin->setSuperAdmin(true);
		$userAdmin->genPublicKey($generator);
		$userAdmin->genPrivateKey($generator);
		$userManager->updateUser($userAdmin);
		$this->addReference("user-". $userAdmin->getEmail(), $userAdmin);

		$userAdmin = $userManager->createUser();
		$userAdmin->setUsername('Lionel');
		$userAdmin->setFirstName('Lionel');
		$userAdmin->setLastName('Hamsou');
		$userAdmin->setPlainPassword('lionelAdmin');
		$userAdmin->setEnabled(true);
		$userAdmin->setEmail('hamsou_l@epitech.eu');
		$userAdmin->setCity($this->getReference("city-Montpellier"));
		$userAdmin->setSuperAdmin(true);
		$userAdmin->genPublicKey($generator);
		$userAdmin->genPrivateKey($generator);
		$userManager->updateUser($userAdmin);
		$this->addReference("user-". $userAdmin->getEmail(), $userAdmin);

		$userAdmin = $userManager->createUser();
		$userAdmin->setUsername('Guillaume');
		$userAdmin->setFirstName('Guillaume');
		$userAdmin->setLastName('De Jabrun');
		$userAdmin->setPlainPassword('guillaumeAdmin');
		$userAdmin->setEnabled(true);
		$userAdmin->setEmail('wylk@datacity.fr');
		$userAdmin->setCity($this->getReference("city-Paris"));
		$userAdmin->setSuperAdmin(true);
		$userAdmin->genPublicKey($generator);
		$userAdmin->genPrivateKey($generator);
		$userManager->updateUser($userAdmin);
		$this->addReference("user-". $userAdmin->getEmail(), $userAdmin);

		$userAdmin = $userManager->createUser();
		$userAdmin->setUsername('Raphael');
		$userAdmin->setFirstName('Raphael');
		$userAdmin->setLastName('Amar');
		$userAdmin->setPlainPassword('raphaelAdmin');
		$userAdmin->setEnabled(true);
		$userAdmin->setEmail('amar_r@epitech.eu');
		$userAdmin->setCity($this->getReference("city-Montpellier"));
		$userAdmin->setSuperAdmin(true);
		$userAdmin->genPublicKey($generator);
		$userAdmin->genPrivateKey($generator);
		$userManager->updateUser($userAdmin);
		$this->addReference("user-". $userAdmin->getEmail(), $userAdmin);

		$userAdmin = $userManager->createUser();
		$userAdmin->setUsername('Ryan');
		$userAdmin->setFirstName('Ryan');
		$userAdmin->setLastName('Legasal');
		$userAdmin->setPlainPassword('ryanAdmin');
		$userAdmin->setEnabled(true);
		$userAdmin->setEmail('legasa_r@epitech.eu');
		$userAdmin->setCity($this->getReference("city-Montpellier"));
		$userAdmin->setSuperAdmin(true);
		$userAdmin->genPublicKey($generator);
		$userAdmin->genPrivateKey($generator);
		$userManager->updateUser($userAdmin);
		$this->addReference("user-". $userAdmin->getEmail(), $userAdmin);

		$userAdmin = $userManager->createUser();
		$userAdmin->setUsername('Cyril');
		$userAdmin->setFirstName('Cyril');
		$userAdmin->setLastName('Morales');
		$userAdmin->setPlainPassword('cyrilAdmin');
		$userAdmin->setEnabled(true);
		$userAdmin->setEmail('cyril.morales@epitech.eu');
		$userAdmin->setCity($this->getReference("city-Montpellier"));
		$userAdmin->setSuperAdmin(true);
		$userAdmin->genPublicKey($generator);
		$userAdmin->genPrivateKey($generator);
		$userManager->updateUser($userAdmin);
		$this->addReference("user-". $userAdmin->getEmail(), $userAdmin);

		$userAdmin = $userManager->createUser();
		$userAdmin->setUsername('admin');
		$userAdmin->setFirstName('Administrateur');
		$userAdmin->setLastName('Datacity');
		$userAdmin->setPlainPassword('admin');
		$userAdmin->setEnabled(true);
		$userAdmin->setEmail('admin@datacity.fr');
		$userAdmin->setCity($this->getReference("city-Paris"));
		$userAdmin->setSuperAdmin(true);
		$userAdmin->genPublicKey($generator);
		$userAdmin->genPrivateKey($generator);
		$userManager->updateUser($userAdmin);
		$this->addReference("user-". $userAdmin->getEmail(), $userAdmin);

		$user = $userManager->createUser();
		$user->setUsername('Johnny');
		$user->setFirstName('John');
		$user->setLastName('Bec');
		$user->setPlainPassword('test00');
		$user->setEnabled(true);
		$user->setEmail('john.doe@example.com');
		//$user->addNews($this->getReference("news-Titre1"));
		$user->genPublicKey($generator);
		$user->genPrivateKey($generator);
		$user->setCity($this->getReference("city-" . CitiesData::$citiesName[0]));
		$userManager->updateUser($user);
		$this->addReference("user-". $user->getEmail(), $user);


	}

	public function getOrder()
	{
		return 8;
	}
}