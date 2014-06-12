<?php

namespace Datacity\PublicBundle\Entity;

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
     * @ORM\Column(name="title", type="string", length=45)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=45)
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
     * @ORM\OneToOne(targetEntity="Datacity\UserBundle\Entity\Creator", inversedBy="dataset")
     * @ORM\JoinColumn(nullable=true)
     */
    private $creator_id;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Contributor", mappedBy="dataset_id", cascade={"persist"})
     */
    private $contributors

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Source", mappedBy="dataset_id", cascade={"persist"})
     */
    private $sources;


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
     * Set creatorId
     *
     * @param integer $creatorId
     * @return Dataset
     */
    public function setCreatorId($creatorId)
    {
        $this->creatorId = $creatorId;

        return $this;
    }

    /**
     * Get creatorId
     *
     * @return integer 
     */
    public function getCreatorId()
    {
        return $this->creatorId;
    }
}
