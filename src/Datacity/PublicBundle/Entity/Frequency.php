<?php

namespace Datacity\PublicBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Frequency
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
class Frequency
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
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     * @Serializer\Expose
     * @Serializer\Groups({"list", "datasetShow"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=60, unique=true)
     * @Serializer\Expose
     * @Serializer\Groups({"list", "datasetShow"})
     */
    private $icon;

    /**
     * @var integer
     *
     * Utile pour trouver la frequence la plus importante
     * lors de la determination de la frequence d'un jeux de donnee.
     * @ORM\Column(name="level", type="integer", unique=true)
     */
    private $level;

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
     * @return Frequency
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
     * Set icon
     *
     * @param string $icon
     * @return Frequency
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Frequency
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }
}
