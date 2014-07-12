<?php

namespace Datacity\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * DataColumns
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
class DataColumns
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
     * Unique=false afin d'autoriser plusieurs nom avec des types differends
     * @ORM\Column(name="name", type="string", length=50, unique=false)
     * @Serializer\Expose
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\DataColumnsType")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Expose
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Dataset", inversedBy="columns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dataset;

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
     * @return DataColumns
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
     * Set type
     *
     * @param \Datacity\PublicBundle\Entity\DataColumnsType $type
     * @return DataColumns
     */
    public function setType(\Datacity\PublicBundle\Entity\DataColumnsType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Datacity\PublicBundle\Entity\DataColumnsType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set dataset
     *
     * @param \Datacity\PublicBundle\Entity\Dataset $dataset
     * @return DataColumns
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
