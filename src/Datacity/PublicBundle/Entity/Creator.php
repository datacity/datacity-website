<?php

namespace Datacity\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Creator
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Creator
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
     * @ORM\OneToOne(targetEntity="Datacity\PublicBundle\Entity\DataSet", mappedBy="creator_id", cascade={"persist"})
     */
    private $dataset

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
