<?php

namespace Datacity\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Datacity\PublicBundle\Entity\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Application", inversedBy="images")
     * @ORM\JoinColumn(nullable=true)
     */
    private $application;
    
    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Category", inversedBy="images")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="images")
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
     * Set url
     *
     * @param string $url
     * @return Image
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
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    
        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set application
     *
     * @param \Datacity\PublicBundle\Entity\Application $application
     * @return Image
     */
   /* public function setApplication(\Datacity\PublicBundle\Entity\Application $application = null)
    {
        $this->application = $application;

        if (isset($application))
	        $application->addImage($this);
        return $this;
    }*/

    /**
     * Get application
     *
     * @return \Datacity\PublicBundle\Entity\Application 
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set category
     *
     * @param \Datacity\PublicBundle\Entity\Category $category
     * @return Image
     */
    public function setCategory(\Datacity\PublicBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        if (isset($category))
	        $category->addImage($this);
        return $this;
    }

    /**
     * Get category
     *
     * @return \Datacity\PublicBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->application = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add application
     *
     * @param \Datacity\PublicBundle\Entity\Application $application
     * @return Image
     */
    public function addApplication(\Datacity\PublicBundle\Entity\Application $application)
    {
        $this->application[] = $application;
    
        return $this;
    }

    /**
     * Remove application
     *
     * @param \Datacity\PublicBundle\Entity\Application $application
     */
    public function removeApplication(\Datacity\PublicBundle\Entity\Application $application)
    {
        $this->application->removeElement($application);
    }

    /**
     * Set user
     *
     * @param \Datacity\UserBundle\Entity\User $user
     * @return Image
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