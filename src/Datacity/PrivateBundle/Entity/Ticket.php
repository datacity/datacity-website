<?php

namespace Datacity\PrivateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Ticket
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="ticketAuthor")
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_time_open", type="datetime")
     */
    private $dateTimeOpen;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_time_update", type="datetime")
     */
    private $dateTimeUpdate;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="ticketAssignedUser")
     */
    private $assignedUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="statut", type="integer")
     */
    private $statut;


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
     *
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
     *
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
     * Set author
     *
     * @param string $author
     *
     * @return Ticket
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
     * Set dateTimeOpen
     *
     * @param \DateTime $dateTimeOpen
     *
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
     *
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
     * Set assignedUser
     *
     * @param string $assignedUser
     *
     * @return Ticket
     */
    public function setAssignedUser($assignedUser)
    {
        $this->assignedUser = $assignedUser;

        return $this;
    }

    /**
     * Get assignedUser
     *
     * @return string
     */
    public function getAssignedUser()
    {
        return $this->assignedUser;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     *
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
}

