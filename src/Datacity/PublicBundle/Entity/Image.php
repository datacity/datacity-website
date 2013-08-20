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
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Application", inversedBy="images")
     * @ORM\JoinColumn(nullable=true)
     */
    private $application;
    
    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Category", inversedBy="images")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;
    
    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Customer", inversedBy="images")
     * @ORM\JoinColumn(nullable=true)
     */
    private $customer;

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
    public function setApplication(\Datacity\PublicBundle\Entity\Application $application = null)
    {
        $this->application = $application;

        if (isset($application))
	        $application->addImage($this);
        return $this;
    }

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
     * Set customer
     *
     * @param \Datacity\PublicBundle\Entity\Customer $customer
     * @return Image
     */
    public function setCustomer(\Datacity\PublicBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;
    	if (isset($customer))
	        $customer->addImage($this);
        return $this;
    }

    /**
     * Get customer
     *
     * @return \Datacity\PublicBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}