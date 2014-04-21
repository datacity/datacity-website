<?php


namespace Datacity\PublicBundle\Entity;

use Datacity\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name = "news")
 * @ORM\Entity(repositoryClass="Datacity\PublicBundle\Entity\NewsRepository")
 */
class News
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
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="news", cascade={"persist"})
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200)
     */
    private $title;

    
    /**
    * @var datetime $date
    *
    * @ORM\Column(name="date", type="datetime")
    */
    private $date;

    public function __construct()
    {
    $this->date = new \Datetime();
    }
    


    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=200)
     */
    private $img;

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
     * Set user
     *
     * @param \Datacity\UserBundle\Entity\User $user
     * @return News
     */
    public function setUser(\Datacity\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }


    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return News
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
     * Set title
     *
     * @param string $title
     * @return News
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
    * Set date
    *
    * @param datetime $date
    * @return News
    */
    public function setDate(\Datetime $date)
    {
        $this->date = $date;
    }

    /**
    * Get date
    *
    * @return datetime
    */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set img
     *
     * @param \String $img
     * @return News
     */
    public function setImg($img)
    {
    	$this->img = $img;
    
    	return $this;
    }
    
    /**
     * Get img
     *
     * @return \String
     */
    public function getImg()
    {
    	return $this->img;
    }
}