<?php

namespace Datacity\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Platform
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Platform
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
     * @ORM\Column(name="version", type="string", length=255)
     */
    private $version;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Application", mappedBy="platforms", cascade={"persist"})
     */
    private $applications;
    

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
     * @return Platform
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
     * Set version
     *
     * @param string $version
     * @return Platform
     */
    public function setVersion($version)
    {
        $this->version = $version;
    
        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add applications
     *
     * @param \Datacity\PublicBundle\Entity\Platform $applications
     * @return Platform
     */
    public function addApplication(\Datacity\PublicBundle\Entity\Platform $applications)
    {
        $this->applications[] = $applications;
    
        return $this;
    }

    /**
     * Remove applications
     *
     * @param \Datacity\PublicBundle\Entity\Platform $applications
     */
    public function removeApplication(\Datacity\PublicBundle\Entity\Platform $applications)
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
}