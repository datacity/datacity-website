<?php

namespace Datacity\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contributor
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Contributor
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
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\Dataset", inversedBy="contributors")
     * @ORM\JoinColumn(nullable=true)
     */
    private $dataset_id;


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
     * Set datasetId
     *
     * @param integer $datasetId
     * @return Contributor
     */
    public function setDatasetId($datasetId)
    {
        $this->datasetId = $datasetId;

        return $this;
    }

    /**
     * Get datasetId
     *
     * @return integer 
     */
    public function getDatasetId()
    {
        return $this->datasetId;
    }
}
