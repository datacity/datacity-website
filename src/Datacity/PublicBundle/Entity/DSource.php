<?php

namespace Datacity\PublicBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Source
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class DSource
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
     * DEPRECATED A enlever sooon
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200)
     */
    private $title;

    /**
     * @var string
     * Le lien vers le site d'origine (non renseigné si identique au dataset).
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     * @Serializer\Groups({"datasetShow"})
     */
    private $link;

    /**
     * @var \Date
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="published_date", type="date")
     * @Serializer\Groups({"datasetShow"})
     */
    private $publishedDate;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="last_update", type="datetime")
     * @Serializer\Groups({"datasetShow"})
     */
    private $lastModifiedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="download_nb", type="integer")
     * @Serializer\Groups({"datasetShow"})
     */
    private $downloadNb = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="useful_nb", type="integer")
     * @Serializer\Groups({"datasetShow"})
     */
    private $usefulNb = 0;

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
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Frequency")
     * @Serializer\Groups({"datasetShow"})
     */
    private $frequency;

     /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Place")
     * @Serializer\Groups({"datasetShow"})
     */
    private $place;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\CoverageTerritory")
     * @Serializer\Groups({"datasetShow"})
     */
    private $coverageTerritory;

     /**
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="sources")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Groups({"datasetShow"})
     */
    private $creator;

     /**
     * Une source ne peut et dois etre dans un seul dataset.
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Dataset", inversedBy="sources")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dataset;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Producer")
     * @Serializer\Groups({"list", "datasetShow"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $producer;

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
     * @return DSource
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
     * Set publishedDate
     *
     * @param \DateTime $publishedDate
     * @return DSource
     */
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    /**
     * Get publishedDate
     *
     * @return \DateTime
     */
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }

    /**
     * Set lastModifiedDate
     *
     * @param \DateTime $lastModifiedDate
     * @return DSource
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
     * Set downloadNb
     *
     * @param integer $downloadNb
     * @return DSource
     */
    public function setDownloadNb($downloadNb)
    {
        $this->downloadNb = $downloadNb;

        return $this;
    }

    /**
     * Get downloadNb
     *
     * @return integer
     */
    public function getDownloadNb()
    {
        return $this->downloadNb;
    }

    /**
     * Set usefulNb
     *
     * @param integer $usefulNb
     * @return DSource
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
     * Set undesirableNb
     *
     * @param integer $undesirableNb
     * @return DSource
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
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     * @return DSource
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
     * @return DSource
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
     * Set frequency
     *
     * @param \Datacity\PublicBundle\Entity\Frequency $frequency
     * @return DSource
     */
    public function setFrequency(\Datacity\PublicBundle\Entity\Frequency $frequency = null)
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
     * Set place
     *
     * @param \Datacity\PublicBundle\Entity\Place $place
     * @return DSource
     */
    public function setPlace(\Datacity\PublicBundle\Entity\Place $place = null)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return \Datacity\PublicBundle\Entity\Place
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set coverageTerritory
     *
     * @param \Datacity\PublicBundle\Entity\CoverageTerritory $coverageTerritory
     * @return DSource
     */
    public function setCoverageTerritory(\Datacity\PublicBundle\Entity\CoverageTerritory $coverageTerritory = null)
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
     * Set creator
     *
     * @param \Datacity\UserBundle\Entity\User $creator
     * @return DSource
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
     * Set dataset
     *
     * @param \Datacity\PublicBundle\Entity\Dataset $dataset
     * @return DSource
     */
    public function setDataset(\Datacity\PublicBundle\Entity\Dataset $dataset)
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

    /**
     * Set link
     *
     * @param string $link
     * @return DSource
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set producer
     *
     * @param \Datacity\UserBundle\Entity\Producer $producer
     * @return DSource
     */
    public function setProducer(\Datacity\PublicBundle\Entity\Producer $producer)
    {
        $this->producer = $producer;

        return $this;
    }

    /**
     * Get producer
     *
     * @return \Datacity\UserBundle\Entity\Producer
     */
    public function getProducer()
    {
        return $this->producer;
    }
}
