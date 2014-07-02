<?php

namespace Datacity\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Category
 *
 * @ORM\Entity
 * @ORM\Table()
 * @Serializer\ExclusionPolicy("all")
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Serializer\Expose
     * @Serializer\Groups({"list", "datasetShow"})
     */
    private $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Image", mappedBy="category", cascade={"persist","remove"})
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Application", mappedBy="categories")
     */
    private $applications;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Dataset", mappedBy="category")
     */
    private $datasets;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datasets = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add datasets
     *
     * @param \Datacity\PublicBundle\Entity\Dataset $datasets
     * @return Category
     */
    public function addDataset(\Datacity\PublicBundle\Entity\Dataset $datasets)
    {
        $this->datasets[] = $datasets;

        return $this;
    }

    /**
     * Remove datasets
     *
     * @param \Datacity\PublicBundle\Entity\Dataset $datasets
     */
    public function removeDataset(\Datacity\PublicBundle\Entity\Dataset $datasets)
    {
        $this->datasets->removeElement($datasets);
    }

    /**
     * Get datasets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatasets()
    {
        return $this->datasets;
    }
}
