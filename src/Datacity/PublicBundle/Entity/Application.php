<?php

namespace Datacity\PublicBundle\Entity;
use Datacity\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table(name="public_application")
 * @ORM\Entity(repositoryClass="Datacity\PublicBundle\Entity\ApplicationRepository")
 */
class Application
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=510)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="downloaded", type="integer")
     */
    private $downloaded;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;
    
    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Image", mappedBy="application", cascade={"persist","remove"})
     */
    private $images;
    
    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\City", inversedBy="applications", cascade={"persist"})
     */
    private $city;
    
    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Platform", inversedBy="applications", cascade={"persist"})
     */
    private $platforms;
    
    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Category", inversedBy="applications", cascade={"persist"})
     */
    private $categories;
    
    /**
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="applications", cascade={"persist"})
     */
    private $user;
    
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
     * Set name
     *
     * @param string $name
     * @return Application
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Application
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->platforms = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        
    }
    
    /**
     * Add images
     *
     * @param \Datacity\PublicBundle\Entity\Image $images
     * @return Application
     */
    public function addImage(\Datacity\PublicBundle\Entity\Image $images)
    {
        $this->images[] = $images;
    
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

    /**
     * Set downloaded
     *
     * @param integer $downloaded
     * @return Application
     */
    public function setDownloaded($downloaded)
    {
        $this->downloaded = $downloaded;
    
        return $this;
    }

    /**
     * Get downloaded
     *
     * @return integer 
     */
    public function getDownloaded()
    {
        return $this->downloaded;
    }

    /**
     * Add platforms
     *
     * @param \Datacity\PublicBundle\Entity\Platform $platforms
     * @return Application
     */
    public function addPlatform(\Datacity\PublicBundle\Entity\Platform $platforms)
    {
        $this->platforms[] = $platforms;
    
        return $this;
    }

    /**
     * Remove platforms
     *
     * @param \Datacity\PublicBundle\Entity\Platform $platforms
     */
    public function removePlatform(\Datacity\PublicBundle\Entity\Platform $platforms)
    {
        $this->platforms->removeElement($platforms);
    }

    /**
     * Get platforms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlatforms()
    {
        return $this->platforms;
    }

    /**
     * Add categories
     *
     * @param \Datacity\PublicBundle\Entity\Category $categories
     * @return Application
     */
    public function addCategorie(\Datacity\PublicBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Datacity\PublicBundle\Entity\Category $categories
     */
    public function removeCategorie(\Datacity\PublicBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set city
     *
     * @param \Datacity\PublicBundle\Entity\City $city
     * @return Application
     */
    public function setCity(\Datacity\PublicBundle\Entity\City $city = null)
    {
        $this->city = $city;
    
        $city->addApplication($this);
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
     * Set url
     *
     * @param string $url
     * @return Application
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set user
     *
     * @param \Datacity\UserBundle\Entity\User $user
     * @return Application
     */
    public function setUser(\Datacity\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Datacity\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}