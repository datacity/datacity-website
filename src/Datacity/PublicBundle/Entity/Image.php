<?php

namespace Datacity\PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *@ORM\Entity
 *@ORM\HasLifecycleCallbacks
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Datacity\PublicBundle\Entity\ImageRepository")
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
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Application", inversedBy="images")
     * @ORM\JoinColumn(nullable=true)
     */
    private $application;
    
    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\Category", inversedBy="images")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity="Datacity\PublicBundle\Entity\News", inversedBy="image")
     * @ORM\JoinColumn(nullable=true)
     */
    private $news;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\UserBundle\Entity\User", inversedBy="images")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    private $file;

    private $tempFilename;
    
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
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
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

    /**
     * Set application
     *
     * @param \Datacity\PublicBundle\Entity\Application $application
     * @return Image
     */
   /* public function setApplication(\Datacity\PublicBundle\Entity\Application $application = null)
    {
        $this->application = $application;

        if (isset($application))
	        $application->addImage($this);
        return $this;
    }*/

    /**
     * Get application
     *
     * @return \Datacity\PublicBundle\Entity\Application 
     */
    public function getApplication()
    {
        return $this->application;
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
    
        if (isset($category))
	        $category->addImage($this);
        return $this;
    }

    /**
     * Get News
     *
     * @return \Datacity\PublicBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

     public function setNews(\Datacity\PublicBundle\Entity\Category $category = null)
    {
        $this->news = $news;
    
        if (isset($news))
            $news->addImage($this);
        return $this;
    }

    /**
     * Get News
     *
     * @return \Datacity\PublicBundle\Entity\News 
     */
    public function getNews()
    {
        return $this->news;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->application = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add application
     *
     * @param \Datacity\PublicBundle\Entity\Application $application
     * @return Image
     */
    public function addApplication(\Datacity\PublicBundle\Entity\Application $application)
    {
        $this->application[] = $application;
    
        return $this;
    }

    /**
     * Remove application
     *
     * @param \Datacity\PublicBundle\Entity\Application $application
     */
    public function removeApplication(\Datacity\PublicBundle\Entity\Application $application)
    {
        $this->application->removeElement($application);
    }

    /**
     * Set user
     *
     * @param \Datacity\UserBundle\Entity\User $user
     * @return Image
     */
    public function setUser(\Datacity\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Datacity\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getFile()
    {
        return $this->file;
    }

   // On modifie le setter de File, pour prendre en compte l'upload d'un fichier lorsqu'il en existe déjà un autre
  public function setFile(UploadedFile $file)
  {
    $this->file = $file;

    // On vérifie si on avait déjà un fichier pour cette entité
    if (null !== $this->url) {
      // On sauvegarde l'extension du fichier pour le supprimer plus tard
      $this->tempFilename = $this->url;

      // On réinitialise les valeurs des attributs url et alt
      $this->url = null;
      $this->alt = null;
    }
  }

  /**
   * @ORM\PrePersist()
   * @ORM\PreUpdate()
   */
  public function preUpload()
  {
    // Si jamais il n'y a pas de fichier (champ facultatif)
    if (null === $this->file) {
      return;
    }

    // Le nom du fichier est son id, on doit juste stocker également son extension
    // Pour faire propre, on devrait renommer cet attribut en « extension », plutôt que « url »
    $this->url = $this->file->guessExtension();

    // Et on génère l'attribut alt de la balise <img>, à la valeur du nom du fichier sur le PC de l'internaute
    $this->alt = $this->file->getClientOriginalName();
  }

  /**
   * @ORM\PostPersist()
   * @ORM\PostUpdate()
   */
  public function upload()
  {
    // Si jamais il n'y a pas de fichier (champ facultatif)
    if (null === $this->file) {
      return;
    }

    // Si on avait un ancien fichier, on le supprime
    if (null !== $this->tempFilename) {
      $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
      if (file_exists($oldFile)) {
        unlink($oldFile);
      }
    }

    // On déplace le fichier envoyé dans le répertoire de notre choix
    $this->file->move(
      $this->getUploadRootDir(), // Le répertoire de destination
      $this->id.'.'.$this->url   // Le nom du fichier à créer, ici « id.extension »
    );
  }

  /**
   * @ORM\PreRemove()
   */
  public function preRemoveUpload()
  {
    // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
    $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
  }

  /**
   * @ORM\PostRemove()
   */
  public function removeUpload()
  {
    // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
    if (file_exists($this->tempFilename)) {
      // On supprime le fichier
      unlink($this->tempFilename);
    }
  }

  public function getUploadDir()
  {
    // On retourne le chemin relatif vers l'image pour un navigateur
    return 'uploads/img';
  }

  protected function getUploadRootDir()
  {
    // On retourne le chemin relatif vers l'image pour notre code PHP
    return __DIR__.'/../../../../web/'.$this->getUploadDir();
  }

  public function getWebPath()
  {
    return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
  }


}