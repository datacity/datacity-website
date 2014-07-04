<?php


namespace Datacity\PublicBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Datacity\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * News
 * @ORM\Entity
 * @ORM\Table(name = "news")
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
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=228, unique=true)
     */
    private $slug;

     /**
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="news")
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
     * @ORM\OneToOne(targetEntity="Datacity\PublicBundle\Entity\Image", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;
    
    /**
    * @var datetime $date
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(name="date", type="datetime")
    */
    private $date;

    public function __construct()
    {
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
     * Set slug
     *
     * @param string $slug
     * @return News
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

    /**
     * Set image
     *
     * @param \Datacity\PublicBundle\Entity\Image $image
     * @return News
     */
    public function setImage(\Datacity\PublicBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Datacity\PublicBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
}
