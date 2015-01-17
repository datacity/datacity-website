<?php

namespace Datacity\PrivateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=100)
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTimeReply", type="datetime")
     */
    private $dateTimeReply;

    /**
     * @var integer
     *
     * @ORM\Column(name="idTicket", type="integer")
     */
    private $idTicket;


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
     * Set idTicket
     *
     * @param integer $idTicket
     *
     * @return ReplyTicket
     */
    public function setIdTicket($idTicket)
    {
        $this->idTicket = $idTicket;

        return $this;
    }

    /**
     * Get idTicket
     *
     * @return integer
     */
    public function getIdTicket()
    {
        return $this->idTicket;
    }
}

