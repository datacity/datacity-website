<?php

namespace Datacity\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Datacity\PublicBundle\Entity\CategoryRepository")
 */
class Category
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
     * @var integer
     *
     * @ORM\Column(name="nb_article", type="integer")
     */
    private $nb_article = 0;
    
    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Image", mappedBy="category", cascade={"persist","remove"})
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Application", mappedBy="categories", cascade={"persist"})
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
     * @return Category
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
     * Set nb_article
     *
     * @param integer $nb_article
     * @return Category
     */
    public function setNb_article($nb_article)
    {
    	$this->nb_article = $nb_article;
    
    	return $this;
    }
    
    /**
     * Get nb_article
     *
     * @return integer
     */
    public function getNb_article()
    {
    	return $this->nb_article;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add images
     *
     * @param \Datacity\PublicBundle\Entity\Image $images
     * @return Category
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
     * Set nb_article
     *
     * @param integer $nbArticle
     * @return Category
     */
    public function setNbArticle($nbArticle)
    {
        $this->nb_article = $nbArticle;
    
        return $this;
    }

    /**
     * Get nb_article
     *
     * @return integer 
     */
    public function getNbArticle()
    {
        return $this->nb_article;
    }

    /**
     * Add applications
     *
     * @param \Datacity\PublicBundle\Entity\Application $applications
     * @return Category
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
}