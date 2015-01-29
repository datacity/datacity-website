<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PrivateBundle\Entity\Ticket;
use Datacity\UserBundle\Entity\User;
use DateTime;

class TicketData extends AbstractFixture implements OrderedFixtureInterface
{
			

	public function load(ObjectManager $manager)
	{
		
		
		// Construction de 3 objets Ticket 

			$ticket = new Ticket();
			$ticket->setTitle("Ajout de sources");
			$ticket->setMessage("Bonjour serait-il possible d'ajouter plusieurs sources à la fois ?");
			$ticket->setDateTimeOpen(new \DateTime('2014-10-12 11:12:44'));
			$ticket->setDateTimeUpdate(new \DateTime('2014-11-12 21:12:44'));
			$ticket->setAuthor($this->getReference("user-marquis_c@epitech.eu"));
			$ticket->setAssignedUser($this->getReference("user-admin@datacity.fr"));
			$ticket->setStatut(2);
			$ticket->setSlug("ajoutdesource");
			$this->addReference("slug-". $ticket->getSlug(), $ticket);
			$manager->persist($ticket);

			$ticket = new Ticket();
			$ticket->setTitle("Problème jeu de donnée");
			$ticket->setMessage("Bonjour je n'arrive à créer un jeu de données");
			$ticket->setDateTimeOpen(new \DateTime('2014-01-10 15:41:44'));
			$ticket->setDateTimeUpdate(new \DateTime('2014-01-17 19:03:44'));
			$ticket->setAuthor($this->getReference("user-marc.soufflet@epitech.eu"));
			$ticket->setAssignedUser($this->getReference("user-admin@datacity.fr"));
			$ticket->setStatut(1);
			$ticket->setSlug("problemjeudedonnee");
			$this->addReference("slug-". $ticket->getSlug(), $ticket);
			$manager->persist($ticket);

			$ticket = new Ticket();
			$ticket->setTitle("Clé public");
			$ticket->setMessage("Bonjour ma clé public pour l'API ne fonctionne pas comment puis-je faire ?");
			$ticket->setDateTimeOpen(new \DateTime('2014-01-15 15:41:44'));
			$ticket->setDateTimeUpdate(new \DateTime('2014-01-15 15:41:44'));
			$ticket->setAuthor($this->getReference("user-hamsou_l@epitech.eu"));
			$ticket->setStatut(0);
			$ticket->setSlug("clepublic");
			$manager->persist($ticket);

			
		$manager->flush();
	}
	
	// Exécution de la fixture aprés l'éxécution des 6 autres.
	public function getOrder()
	{
		return 14;
	}
}
