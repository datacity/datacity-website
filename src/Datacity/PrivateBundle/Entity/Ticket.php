<?php

namespace Datacity\PrivateBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Ticket
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Ticket
{

    const OPEN = 0;
    const ASSIGNED = 1;
    const CLOSE = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=228, unique=true)
     * @Serializer\Groups({"userTickets"})
     */
    private $slug;

     /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200)
     * @Serializer\Groups({"userTickets"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     * @Serializer\Groups({"userTickets"})
     */
    private $message;

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="ticketAuthor")
     * @Serializer\Groups({"userTickets"})
     * @Serializer\MaxDepth(1)
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date_time_open", type="datetime")
     * @Serializer\Groups({"userTickets"})
     * @Serializer\Type("DateTime<'d-m-Y H:i:s'>")
     */
    private $dateTimeOpen;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="date_time_update", type="datetime")
     * @Serializer\Groups({"userTickets"})
     * @Serializer\Type("DateTime<'d-m-Y H:i:s'>")
     */
    private $dateTimeUpdate;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="ticketAssignedUser")
     * @Serializer\Groups({"userTickets"})
     * @Serializer\MaxDepth(1)
     */
    private $assignedUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer")
     * @Serializer\Groups({"userTickets"})
     */
    private $statut = self::OPEN;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PrivateBundle\Entity\ReplyTicket", mappedBy="ticket", cascade={"remove"})
     * @Serializer\Groups({"userTickets"})
     */
     private $reponses;

       /**
     * Constructor
     */
    public function __construct()
    {
        $this->reponses = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     * @return Ticket
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Ticket
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
     * Set dateTimeOpen
     *
     * @param \DateTime $dateTimeOpen
     * @return Ticket
     */
    public function setDateTimeOpen($dateTimeOpen)
    {
        $this->dateTimeOpen = $dateTimeOpen;

        return $this;
    }

    /**
     * Get dateTimeOpen
     *
     * @return \DateTime 
     */
    public function getDateTimeOpen()
    {
        return $this->dateTimeOpen;
    }

    /**
     * Set dateTimeUpdate
     *
     * @param \DateTime $dateTimeUpdate
     * @return Ticket
     */
    public function setDateTimeUpdate($dateTimeUpdate)
    {
        $this->dateTimeUpdate = $dateTimeUpdate;

        return $this;
    }

    /**
     * Get dateTimeUpdate
     *
     * @return \DateTime 
     */
    public function getDateTimeUpdate()
    {
        return $this->dateTimeUpdate;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     * @return Ticket
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return integer 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set author
     *
     * @param \Datacity\UserBundle\Entity\User $author
     * @return Ticket
     */
    public function setAuthor(\Datacity\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Datacity\UserBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set assignedUser
     *
     * @param \Datacity\UserBundle\Entity\User $assignedUser
     * @return Ticket
     */
    public function setAssignedUser(\Datacity\UserBundle\Entity\User $assignedUser = null)
    {
        $this->assignedUser = $assignedUser;

        return $this;
    }

    /**
     * Get assignedUser
     *
     * @return \Datacity\UserBundle\Entity\User 
     */
    public function getAssignedUser()
    {
        return $this->assignedUser;
    }

    /**
     * Add reponses
     *
     * @param \Datacity\PrivateBundle\Entity\ReplyTicket $reponses
     * @return Ticket
     */
    public function addReponse(\Datacity\PrivateBundle\Entity\ReplyTicket $reponses)
    {
        $this->reponses[] = $reponses;

        return $this;
    }

    /**
     * Remove reponses
     *
     * @param \Datacity\PrivateBundle\Entity\ReplyTicket $reponses
     */
    public function removeReponse(\Datacity\PrivateBundle\Entity\ReplyTicket $reponses)
    {
        $this->reponses->removeElement($reponses);
    }

    /**
     * Get reponses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReponses()
    {
        return $this->reponses;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Ticket
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
