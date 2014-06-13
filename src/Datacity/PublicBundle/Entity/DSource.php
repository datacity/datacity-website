<?php

namespace Datacity\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=45)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="decimal")
     */
    private $size;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="published_date", type="datetime")
     */
    private $publishedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="download_nb", type="integer")
     */
    private $downloadNb;

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
     * @var \DateTime
     *
     * @ORM\Column(name="date_begin", type="datetime")
     */
    private $dateBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime")
     */
    private $dateEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="territory_covery", type="string", length=45)
     */
    private $territoryCovery;

    /**
     * @var string
     *
     * @ORM\Column(name="referency", type="string", length=45)
     */
    private $referency;

    /**
     * @var string
     *
     * @ORM\Column(name="license", type="string", length=45)
     */
    private $license;

    /**
     * @var string
     *
     * @ORM\Column(name="frequency", type="string", length=45)
     */
    private $frequency;

    /**
     * @ORM\OneToOne(targetEntity="Datacity\UserBundle\Entity\File", inversedBy="files")
     * @ORM\JoinColumn(nullable=true)
     */
    private $file_id;

     /**
     * @ORM\OneToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="sources")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user_id;

    /**
     * @ORM\OneToOne(targetEntity="Datacity\UserBundle\Entity\Category", inversedBy="sources")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category_id;

     /**
     * @ORM\ManyToMany(targetEntity="Datacity\UserBundle\Entity\Dataset", inversedBy="sources")
     * @ORM\JoinColumn(nullable=true)
     */
    private $datasets;

     /**
     * @ORM\OneToOne(targetEntity="Datacity\PublicBundle\Entity\Tag", mappedBy="source_id", cascade={"persist"})
     */
    private $tag;


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
     * Set place
     *
     * @param string $place
     * @return Source
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return Source
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set publishedDate
     *
     * @param \DateTime $publishedDate
     * @return Source
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
     * Set downloadNb
     *
     * @param integer $downloadNb
     * @return Source
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
     * @return Source
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
     * @return Source
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
     * @return Source
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
     * @return Source
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
     * @return Source
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
     * Set territoryCovery
     *
     * @param string $territoryCovery
     * @return Source
     */
    public function setTerritoryCovery($territoryCovery)
    {
        $this->territoryCovery = $territoryCovery;

        return $this;
    }

    /**
     * Get territoryCovery
     *
     * @return string 
     */
    public function getTerritoryCovery()
    {
        return $this->territoryCovery;
    }

    /**
     * Set referency
     *
     * @param string $referency
     * @return Source
     */
    public function setReferency($referency)
    {
        $this->referency = $referency;

        return $this;
    }

    /**
     * Get referency
     *
     * @return string 
     */
    public function getReferency()
    {
        return $this->referency;
    }

    /**
     * Set license
     *
     * @param string $license
     * @return Source
     */
    public function setLicense($license)
    {
        $this->license = $license;

        return $this;
    }

    /**
     * Get license
     *
     * @return string 
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * Set frequency
     *
     * @param string $frequency
     * @return Source
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return string 
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set fileId
     *
     * @param integer $fileId
     * @return Source
     */
    public function setFileId($fileId)
    {
        $this->fileId = $fileId;

        return $this;
    }

    /**
     * Get fileId
     *
     * @return integer 
     */
    public function getFileId()
    {
        return $this->fileId;
    }
}
