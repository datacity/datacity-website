<?php

namespace Datacity\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Datacity\PublicBundle\Entity\CityRepository")
 */
class City
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
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Application", mappedBy="city", cascade={"persist"})
     */
    private $applications;
    
    /**
     * @ORM\OneToMany(targetEntity="Datacity\UserBundle\Entity\User", mappedBy="city", cascade={"persist"})
     */
    private $users;

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
     * @return City
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
     * Constructor
     */
    public function __construct()
    {
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add applications
     *
     * @param \Datacity\PublicBundle\Entity\Application $applications
     * @return City
     */
    public function addApplication(\Datacity\PublicBundle\Entity\Application $applications)
    {
        $this->applications[] = $applications;
    
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
     * Add users
     *
     * @param \Datacity\UserBundle\Entity\User $users
     * @return City
     */
    public function addUser(\Datacity\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \Datacity\UserBundle\Entity\User $users
     */
    public function removeUser(\Datacity\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}