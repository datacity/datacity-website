<?php

namespace Datacity\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="datacity_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=50)
     * 
     * @Assert\NotBlank(message="Entrez votre prénom.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="Le prénom est trop petit..",
     *     maxMessage="Le prénom est trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=50)
     * 
     * @Assert\NotBlank(message="Entrez votre nom.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="Le nom est trop petit..",
     *     maxMessage="Le nom est trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $lastname;

     /**
     * @var int
     *
     * @ORM\Column(name="point", type="int", length=50)
     */

    private $point;

      /**
     * @var text
     *
     * @ORM\Column(name="description", type="text", length=500)
     */

    private $description;

      /**
     * @var string
     *
     * @ORM\Column(name="public_key", type="string", length=50)
     */

    private $public_key;

      /**
     * @var string
     *
     * @ORM\Column(name="private_key", type="string", length=50)
     */

    private $private_key;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=50)
     */

    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=45)
     */

    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=45)
     */

    private $langue;


    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Application", mappedBy="user", cascade={"remove", "persist"})
     */

    private $applications;
    
    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\City", inversedBy="users", cascade={"persist"})
     */
    private $city;
    
    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Image", mappedBy="user")
     */
    private $images;


    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\News", mappedBy="user", cascade={"persist"})
     */
    private $news;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Source", mappedBy="user", cascade={"persist"})
     */
    private $sources;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Follower", mappedBy="user", cascade={"persist"})
     */
    private $followers;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\File", mappedBy="user_id", cascade={"persist"})
     */
    private $files;

    
    public function __construct()
    {
    	parent::__construct();
    	//May add something here later...
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
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    
    /**
     * Add news
     *
     * @param \Datacity\PublicBundle\Entity\News $news
     * @return User
     */
    public function addNews(\Datacity\PublicBundle\Entity\News $news)
    {
        $this->news[] = $news;
        $news->setUser($this);
        return $this;
    }

    /**
     * Remove news
     *
     * @param \Datacity\PublicBundle\Entity\News $news
     */
    public function removeNews(\Datacity\PublicBundle\Entity\News $news)
    {
        $this->news->removeElement($news);
    }

    /**
     * Get news
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNews()
    {
        return $this->news;
    }


    /**
     * Add applications
     *
     * @param \Datacity\PublicBundle\Entity\Application $applications
     * @return User
     */
    public function addApplication(\Datacity\PublicBundle\Entity\Application $applications)
    {
        $this->applications[] = $applications;
        
    	$applications->setUser($this);
        return $this;
    }

    /**
     * Remove applications
     *
     * @param \Datacity\PublicBundle\Entity\Application $applications
     */
    public function removeApplication(\Datacity\PublicBundle\Entity\Application $applications)
    {
        $this->applications->removeElement($applications);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set city
     *
     * @param \Datacity\PublicBundle\Entity\City $city
     * @return User
     */
    public function setCity(\Datacity\PublicBundle\Entity\City $city = null)
    {
        $this->city = $city;
    	$city->addUser($this);
        
        return $this;
    }

    /**
     * Get city
     *
     * @return \Datacity\PublicBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Add images
     *
     * @param \Datacity\PublicBundle\Entity\Image $images
     * @return User
     */
    public function addImage(\Datacity\PublicBundle\Entity\Image $images)
    {
        $this->images[] = $images;
        
    	$images->setUser($this);
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Datacity\PublicBundle\Entity\Image $images
     */
    public function removeImage(\Datacity\PublicBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}