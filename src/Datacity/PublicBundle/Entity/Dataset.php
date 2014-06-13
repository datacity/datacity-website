<?php

namespace Datacity\PublicBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Dataset
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Dataset
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
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="useful_nb", type="integer")
     */
    private $usefulNb;

    /**
     * @var integer
     *
     * @ORM\Column(name="visited_nb", type="integer")
     */
    private $visitedNb;

    /**
     * @var integer
     *
     * @ORM\Column(name="undesirable_nb", type="integer")
     */
    private $undesirableNb;

    /**
     * @var integer
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="creation_date", type="date")
     */
    private $creationDate;

    /**
     * @var integer
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="last_update", type="datetime")
     */
    private $lastUpdate;

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="datasetOwned")
     */
    private $creator;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\UserBundle\Entity\User", mappedBy="datasetContributed")
     */
    private $contributors;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\DSource", mappedBy="datasets")
     */
    private $sources;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contributors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sources = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set creator
     *
     * @param \Datacity\UserBundle\Entity\User $creator
     * @return Dataset
     */
    public function setCreator(\Datacity\UserBundle\Entity\User $creator = null)
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
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return Dataset
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime 
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
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
}
