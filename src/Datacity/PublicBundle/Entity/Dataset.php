<?php

namespace Datacity\PublicBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Dataset
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Datacity\PublicBundle\Entity\DatasetRepository")
 */
class Dataset
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Exclude
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200)
     * @Serializer\Groups({"list", "datasetShow", "userList"})
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=228, unique=true)
     * @Serializer\Groups({"list", "datasetShow", "userList"})
     */
    private $slug;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Serializer\Groups({"list", "datasetShow", "userList"})
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="useful_nb", type="integer")
     * @Serializer\Groups({"datasetShow", "userList"})
     */
    private $usefulNb = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="visited_nb", type="integer")
     * @Serializer\Groups({"datasetShow", "userList"})
     */
    private $visitedNb = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="undesirable_nb", type="integer")
     * @Serializer\Groups({"datasetShow"})
     */
    private $undesirableNb = 0;

    /**
     * @var \Date
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="creation_date", type="date")
     * @Serializer\Groups({"datasetShow"})
     * @Serializer\Type("DateTime<'d-m-Y'>")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="last_update", type="datetime")
     * @Serializer\Groups({"list", "datasetShow", "userList"})
     * @Serializer\Type("DateTime<'d-m-Y'>")
     */
    private $lastModifiedDate;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date_begin", type="date", nullable=true)
     * @Serializer\Groups({"datasetShow"})
     */
    private $dateBegin;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date_end", type="date", nullable=true)
     * @Serializer\Groups({"datasetShow"})
     */
    private $dateEnd;

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="datasetOwned")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Groups({"list", "datasetShow"})
     */
    private $creator;

    /**
     * L'ensemble des lieux de chaques sources du dataset.
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Place")
     * @Serializer\Groups({"list", "datasetShow"})
     */
    private $places;

    /**
     * La couverture la plus grande des sources du dataset.
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\CoverageTerritory")
     * @Serializer\Groups({"list", "datasetShow"})
     */
    private $coverageTerritory;

    /**
     * La frequence la plus courte des sources du dataset.
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Frequency")
     * @Serializer\Groups({"list", "datasetShow"})
     */
    private $frequency;

    /**
     * L'ensemble des createurs de chaques sources du dataset.
     * @ORM\ManyToMany(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="datasetContributed")
     * @Serializer\Groups({"datasetShow"})
     */
    private $contributors;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\DSource", mappedBy="dataset")
     * @Serializer\Groups({"datasetShow"})
     */
    private $sources;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Groups({"list", "datasetShow"})
     */
    private $categories;

    /**
     * L'ensemble des tags de chaques sources du dataset.
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Tag")
     * @Serializer\Groups({"datasetShow"})
     */
    private $tags;

    /**
     * Les colonnes du dataset.
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\DataColumns", mappedBy="dataset", fetch="EXTRA_LAZY")
     * @Serializer\Groups({"datasetShow"})
     */
    private $columns;

    /**
     * La licence du dataset.
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\License")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Groups({"list", "datasetShow"})
     */
    private $license;

    /**
     * Les applications du dataset.
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Application", mappedBy="dataset")
     * @Serializer\Groups({"datasetShow"})
     */
    private $applications;

    /**
     * Si le dataset doit etre public ou non.
     * @ORM\Column(name="is_public", type="boolean")
     * @Serializer\Groups({"list"})
     */
    private $isPublic = true;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->places = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contributors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->columns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Dataset
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Dataset
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
     * Set description
     *
     * @param string $description
     * @return Dataset
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
     * Set usefulNb
     *
     * @param integer $usefulNb
     * @return Dataset
     */
    public function setUsefulNb($usefulNb)
    {
        $this->usefulNb = $usefulNb;

        return $this;
    }

    /**
     * Get usefulNb
     *
     * @return integer
     */
    public function getUsefulNb()
    {
        return $this->usefulNb;
    }

    /**
     * Set visitedNb
     *
     * @param integer $visitedNb
     * @return Dataset
     */
    public function setVisitedNb($visitedNb)
    {
        $this->visitedNb = $visitedNb;

        return $this;
    }

    /**
     * Get visitedNb
     *
     * @return integer
     */
    public function getVisitedNb()
    {
        return $this->visitedNb;
    }

    /**
     * Set undesirableNb
     *
     * @param integer $undesirableNb
     * @return Dataset
     */
    public function setUndesirableNb($undesirableNb)
    {
        $this->undesirableNb = $undesirableNb;

        return $this;
    }

    /**
     * Get undesirableNb
     *
     * @return integer
     */
    public function getUndesirableNb()
    {
        return $this->undesirableNb;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Dataset
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set lastModifiedDate
     *
     * @param \DateTime $lastModifiedDate
     * @return Dataset
     */
    public function setLastModifiedDate($lastModifiedDate)
    {
        $this->lastModifiedDate = $lastModifiedDate;

        return $this;
    }

    /**
     * Get lastModifiedDate
     *
     * @return \DateTime
     */
    public function getLastModifiedDate()
    {
        return $this->lastModifiedDate;
    }

    /**
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     * @return Dataset
     */
    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    /**
     * Get dateBegin
     *
     * @return \DateTime
     */
    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Dataset
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set creator
     *
     * @param \Datacity\UserBundle\Entity\User $creator
     * @return Dataset
     */
    public function setCreator(\Datacity\UserBundle\Entity\User $creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \Datacity\UserBundle\Entity\User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set coverageTerritory
     *
     * @param \Datacity\PublicBundle\Entity\CoverageTerritory $coverageTerritory
     * @return Dataset
     */
    public function setCoverageTerritory(\Datacity\PublicBundle\Entity\CoverageTerritory $coverageTerritory)
    {
        $this->coverageTerritory = $coverageTerritory;

        return $this;
    }

    /**
     * Get coverageTerritory
     *
     * @return \Datacity\PublicBundle\Entity\CoverageTerritory
     */
    public function getCoverageTerritory()
    {
        return $this->coverageTerritory;
    }

    /**
     * Add contributors
     *
     * @param \Datacity\UserBundle\Entity\User $contributors
     * @return Dataset
     */
    public function addContributor(\Datacity\UserBundle\Entity\User $contributors)
    {
        $this->contributors[] = $contributors;

        return $this;
    }

    /**
     * Remove contributors
     *
     * @param \Datacity\UserBundle\Entity\User $contributors
     */
    public function removeContributor(\Datacity\UserBundle\Entity\User $contributors)
    {
        $this->contributors->removeElement($contributors);
    }

    /**
     * Get contributors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContributors()
    {
        return $this->contributors;
    }

    /**
     * Add sources
     *
     * @param \Datacity\PublicBundle\Entity\DSource $sources
     * @return Dataset
     */
    public function addSource(\Datacity\PublicBundle\Entity\DSource $sources)
    {
        $this->sources[] = $sources;

        return $this;
    }

    /**
     * Remove sources
     *
     * @param \Datacity\PublicBundle\Entity\DSource $sources
     */
    public function removeSource(\Datacity\PublicBundle\Entity\DSource $sources)
    {
        $this->sources->removeElement($sources);
    }

    /**
     * Get sources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * Add tags
     *
     * @param \Datacity\PublicBundle\Entity\Tag $tags
     * @return Dataset
     */
    public function addTag(\Datacity\PublicBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Datacity\PublicBundle\Entity\Tag $tags
     */
    public function removeTag(\Datacity\PublicBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add columns
     *
     * @param \Datacity\PublicBundle\Entity\DataColumns $columns
     * @return Dataset
     */
    public function addColumn(\Datacity\PublicBundle\Entity\DataColumns $columns)
    {
        $this->columns[] = $columns;

        return $this;
    }

    /**
     * Remove columns
     *
     * @param \Datacity\PublicBundle\Entity\DataColumns $columns
     */
    public function removeColumn(\Datacity\PublicBundle\Entity\DataColumns $columns)
    {
        $this->columns->removeElement($columns);
    }

    /**
     * Get columns
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set license
     *
     * @param \Datacity\PublicBundle\Entity\License $license
     * @return Dataset
     */
    public function setLicense(\Datacity\PublicBundle\Entity\License $license)
    {
        $this->license = $license;

        return $this;
    }

    /**
     * Get license
     *
     * @return \Datacity\PublicBundle\Entity\License
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * Set frequency
     *
     * @param \Datacity\PublicBundle\Entity\Frequency $frequency
     * @return Dataset
     */
    public function setFrequency(\Datacity\PublicBundle\Entity\Frequency $frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return \Datacity\PublicBundle\Entity\Frequency
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Add places
     *
     * @param \Datacity\PublicBundle\Entity\Place $places
     * @return Dataset
     */
    public function addPlace(\Datacity\PublicBundle\Entity\Place $places)
    {
        $this->places[] = $places;

        return $this;
    }

    /**
     * Remove places
     *
     * @param \Datacity\PublicBundle\Entity\Place $places
     */
    public function removePlace(\Datacity\PublicBundle\Entity\Place $places)
    {
        $this->places->removeElement($places);
    }

    /**
     * Get places
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * Add category
     *
     * @param \Datacity\PublicBundle\Entity\Category $category
     * @return Dataset
     */
    public function addCategory(\Datacity\PublicBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Datacity\PublicBundle\Entity\Category $category
     */
    public function removeCategory(\Datacity\PublicBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add applications
     *
     * @param \Datacity\PublicBundle\Entity\Application $applications
     * @return Dataset
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
     * Set isPublic
     *
     * @param boolean $isPublic
     * @return Dataset
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }
}
