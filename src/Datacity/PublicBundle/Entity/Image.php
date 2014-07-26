<?php

namespace Datacity\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Image
 *
 * @ORM\Entity
 * @ORM\Table()
 * @Gedmo\Uploadable(path="/uploads/img", allowOverwrite=true, filenameGenerator="ALPHANUMERIC")
 */
class Image
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
     * @ORM\Column(name="path", type="string", length=255, unique=true)
     * @Gedmo\UploadableFilePath
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Gedmo\UploadableFileName
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\Column(name="size", type="decimal")
     * @Gedmo\UploadableFileSize
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="mime_type", type="string")
     * @Gedmo\UploadableFileMimeType
     */
    private $mimeType;

     /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Category", inversedBy="images")
     */
    private $category;

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
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Image
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
     * Set mimeType
     *
     * @param string $mimeType
     * @return Image
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return Image
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
     * Set category
     *
     * @param \Datacity\PublicBundle\Entity\Category $category
     * @return Image
     */
    public function setCategory(\Datacity\PublicBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Datacity\PublicBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
}
