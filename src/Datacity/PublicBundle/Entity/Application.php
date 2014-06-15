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
     * @var integer
     *
     * @ORM\Column(name="useful_nb", type="integer")
     */
    private $useful_nb;

    /**
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

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
}