<?php

namespace Datacity\PrivateBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * ReplyTicket
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ReplyTicket
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var text
     *
     * @ORM\Column(name="message", type="text")
     * @Serializer\Groups({"userTickets"})
     */
    private $message;

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User")
     * @Serializer\Groups({"userTickets"})
     */
    private $author;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="dateTimeReply", type="datetime")
     * @Serializer\Groups({"userTickets"})
     * @Serializer\Type("DateTime<'d-m-Y H:i:s'>")
     *
     */
    private $dateTimeReply;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PrivateBundle\Entity\Ticket", inversedBy="reponses")
     */
    private $ticket;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return ReplyTicket
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return ReplyTicket
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set dateTimeReply
     *
     * @param \DateTime $dateTimeReply
     *
     * @return ReplyTicket
     */
    public function setDateTimeReply($dateTimeReply)
    {
        $this->dateTimeReply = $dateTimeReply;

        return $this;
    }

    /**
     * Get dateTimeReply
     *
     * @return \DateTime
     */
    public function getDateTimeReply()
    {
        return $this->dateTimeReply;
    }

   

    /**
     * Set ticket
     *
     * @param \Datacity\PrivateBundle\Entity\Ticket $ticket
     * @return ReplyTicket
     */
    public function setTicket(\Datacity\PrivateBundle\Entity\Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \Datacity\PrivateBundle\Entity\Ticket 
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}
