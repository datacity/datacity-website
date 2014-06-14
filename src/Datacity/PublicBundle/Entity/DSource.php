<?php

namespace Datacity\PublicBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
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
     * @ORM\Column(name="title", type="string", length=200)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=228, unique=true)
     */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="sid", type="integer")
     */
    private $sid;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var decimal
     *
     * @ORM\Column(name="size", type="decimal")
     */
    private $size;

    /**
     * @var \Date
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="published_date", type="date")
     */
    private $publishedDate;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="last_update", type="datetime")
     */
    private $lastModifiedDate;

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
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\Frequency")
     */
    private $frequency;

     /**
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\Place")
     */
    private $place;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\CoverageTerritory")
     */
    private $coverageTerritory;

     /**
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="sources")
     */
    private $creator;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\Category", inversedBy="sources")
     */
    private $category;

     /**
     * @ORM\ManyToMany(targetEntity="Datacity\UserBundle\Entity\Dataset", mappedBy="sources")
     * @ORM\JoinColumn(nullable=true)
     */
    private $datasets;

     /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Tag", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $tag;
}
