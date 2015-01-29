<?php

namespace Datacity\PublicBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Datacity\PrivateBundle\Entity\Ticket;
use Datacity\PrivateBundle\Entity\ReplyTicket;
use Datacity\UserBundle\Entity\User;
use DateTime;

class ReplyTicketData extends AbstractFixture implements OrderedFixtureInterface
{
			

	public function load(ObjectManager $manager)
	{
		
		
		// Construction de 3 objets Ticket 

			$ticket = new ReplyTicket();
			$ticket->setMessage("Oui biensure il suffit d'aller dans l'etape 1 du wizzard");
			$ticket->setDateTimeReply(new \DateTime('2014-10-12 20:54:44'));
			$ticket->setAuthor($this->getReference("user-admin@datacity.fr"));
			$ticket->setTicket($this->getReference("slug-ajoutdesource"));
			$manager->persist($ticket);

			$ticket = new ReplyTicket();
			$ticket->setMessage("Trés bien merci pour votre réponse");
			$ticket->setDateTimeReply(new \DateTime('2014-11-12 15:41:44'));
			$ticket->setAuthor($this->getReference("user-marquis_c@epitech.eu"));
			$ticket->setTicket($this->getReference("slug-ajoutdesource"));
			$manager->persist($ticket);

			$ticket = new ReplyTicket();
			$ticket->setMessage("Pas de problème n'hésitez pas à revenir vers nous en cas de problème");
			$ticket->setDateTimeReply(new \DateTime('2014-11-12 21:12:44'));
			$ticket->setAuthor($this->getReference("user-admin@datacity.fr"));
			$ticket->setTicket($this->getReference("slug-ajoutdesource"));
			$manager->persist($ticket);

			$ticket = new ReplyTicket();
			$ticket->setMessage("Avez-vous essayez depuis le back office ?");
			$ticket->setDateTimeReply(new \DateTime('2014-01-17 18:36:44'));
			$ticket->setAuthor($this->getReference("user-admin@datacity.fr"));
			$ticket->setTicket($this->getReference("slug-problemjeudedonnee"));
			$manager->persist($ticket);

			$ticket = new ReplyTicket();
			$ticket->setMessage("Justement je n'arrive pas a accéder à mon back office savez-vous d'où ca pourrait venir ?");
			$ticket->setDateTimeReply(new \DateTime('2014-01-17 19:03:44'));
			$ticket->setAuthor($this->getReference("user-marc.soufflet@epitech.eu"));
			$ticket->setTicket($this->getReference("slug-problemjeudedonnee"));
			$manager->persist($ticket);

			
			
		$manager->flush();
	}
	
	// Exécution de la fixture aprés l'éxécution des 6 autres.
	public function getOrder()
	{
		return 19;
	}
}
