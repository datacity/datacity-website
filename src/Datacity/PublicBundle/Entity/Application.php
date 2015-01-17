<?php

namespace Datacity\PublicBundle\Entity;
use JMS\Serializer\Annotation as Serializer;
use Datacity\UserBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
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
     * @ORM\Column(name="name", type="string", length=200)
     * @Serializer\Groups({"datasetShow", "userApplications"})
     */
    private $name;

    /**
     * @var string
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=228, unique=true)
     * @Serializer\Groups({"datasetShow", "userApplications"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=510)
     * @Serializer\Groups({"datasetShow", "userApplications"})
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="downloaded", type="integer")
     * @Serializer\Groups({"datasetShow", "userApplications"})
     */
    private $downloaded;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Serializer\Groups({"datasetShow", "userApplications"})
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     * @Serializer\Groups({"datasetShow", "userApplications"})
     */
    private $rating;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Image", cascade={"persist","remove"})
     * @Serializer\Groups({"datasetShow", "userApplications"})
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\City", cascade={"persist"})
     * @Serializer\Groups({"datasetShow", "userApplications"})
     */
    private $city;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Platform", inversedBy="applications", cascade={"persist"})
     * @Serializer\Groups({"datasetShow", "userApplications"})
     */
    private $platforms;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Category", inversedBy="applications", cascade={"persist"})
     * @Serializer\Groups({"datasetShow", "userApplications"})
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="applications", cascade={"persist"})
     * @Serializer\Groups({"datasetShow", "userApplications"})
     * @Gedmo\Blameable(on="create")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Dataset", inversedBy="applications")
     * @Serializer\Groups({"datasetShow", "userApplications"})
     */
    private $dataset;

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
     * Set rating
     *
     * @param integer $rating
     * @return Application
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
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
     * Set city
     *
     * @param \Datacity\PublicBundle\Entity\City $city
     * @return Application
     */
    public function setCity(\Datacity\PublicBundle\Entity\City $city = null)
    {
        $this->city = $city;

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
     * Remove platforms
     *
     *
     */
    public function removePlatforms()
    {
        $this->platforms=null;
    }

    /**
     * Add categories
     *
     * @param \Datacity\PublicBundle\Entity\Category $categories
     * @return Application
     */
    public function addCategory(\Datacity\PublicBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Datacity\PublicBundle\Entity\Category $categories
     */
    public function removeCategory(\Datacity\PublicBundle\Entity\Category $categories)
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
     * Remove categories
     *
     *
     */
    public function removeCategories()
    {
        $this->categories=null;
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

    /**
     * Set slug
     *
     * @param string $slug
     * @return Application
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
     * Set dataset
     *
     * @param \Datacity\PublicBundle\Entity\Dataset $dataset
     * @return Application
     */
    public function setDataset(\Datacity\PublicBundle\Entity\Dataset $dataset = null)
    {
        $this->dataset = $dataset;

        return $this;
    }

    /**
     * Get dataset
     *
     * @return \Datacity\PublicBundle\Entity\Dataset
     */
    public function getDataset()
    {
        return $this->dataset;
    }
}
