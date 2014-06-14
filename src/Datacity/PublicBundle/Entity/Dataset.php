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
     * @ORM\Column(name="did", type="integer")
     */
    private $did;

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
     * @var \Date
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="creation_date", type="date")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="last_update", type="datetime")
     */
    private $lastModifiedDate;

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="datasetOwned")
     */
    private $creator;

    /**
     * L'ensemble des lieux de chaques sources du dataset.
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Place")
     */
    private $places;

    /**
     * La couverture la plus grande des sources du dataset.
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\CoverageTerritory")
     */
    private $coverageTerritory;

    /**
     * L'ensemble des createur de chaques sources du dataset.
     * @ORM\ManyToMany(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="datasetContributed")
     */
    private $contributors;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\DSource", inversedBy="datasets")
     */
    private $sources;

    /**
     * L'ensemble des categories de chaques sources du dataset.
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Category", inversedBy="datasets")
     */
    private $categories;

    /**
     * L'ensemble des tags de chaques sources du dataset.
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Tag")
     */
    private $tags;
}
