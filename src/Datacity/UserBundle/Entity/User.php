<?php

namespace Datacity\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * User
 *
 * @ORM\Table(name="datacity_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=50)
     * 
     * @Assert\NotBlank(message="Entrez votre prénom.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="Le prénom est trop petit..",
     *     maxMessage="Le prénom est trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=50)
     * 
     * @Assert\NotBlank(message="Entrez votre nom.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="Le nom est trop petit..",
     *     maxMessage="Le nom est trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $lastname;

     /**
     * @var integer
     *
     * @ORM\Column(name="point", type="integer")
     */

    private $point = 0;

      /**
     * @var text
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */

    private $description;

      /**
     * @var string
     *
     * @ORM\Column(name="public_key", type="string", length=50, nullable=false)
     */

    private $public_key;

      /**
     * @var string
     *
     * @ORM\Column(name="private_key", type="string", length=50, nullable=false)
     */

    private $private_key;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=50, nullable=true)
     */

    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=45, nullable=true)
     */

    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=45, nullable=true)
     */

    private $langue;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Application", mappedBy="user", cascade={"remove", "persist"})
     */

    private $applications;
    
    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\City", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $city;
    
    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Image", mappedBy="user")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\News", mappedBy="user", cascade={"persist"})
     */
    private $news;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\DSource", mappedBy="creator", cascade={"persist"})
     */
    private $sources;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="followers")
     * @ORM\JoinTable(name="user_followers",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="follower_id", referencedColumnName="id")}
     *      )
     */
    private $followed;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="followed")
     */
    private $followers;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\File", mappedBy="user", cascade={"persist"})
     */
    private $files;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Dataset", mappedBy="creator")
     */
    private $datasetOwned;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Dataset", mappedBy="contributors")
     */
    private $datasetContributed;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->news = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->followed = new \Doctrine\Common\Collections\ArrayCollection();
        $this->followers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datasetOwned = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datasetContributed = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set point
     *
     * @param integer $point
     * @return User
     */
    public function setPoint($point)
    {
        $this->point = $point;

        return $this;
    }

    /**
     * Get point
     *
     * @return integer 
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return User
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set public_key
     *
     * @param string $publicKey
     * @return User
     */
    public function setPublicKey($publicKey)
    {
        $this->public_key = $publicKey;

        return $this;
    }

    /**
     * Generate public_key
     *
     * @param SecureRandom $generator
     * @return User
     */
    public function genPublicKey($generator)
    {
        return $this->setPublicKey(hash('md5', $generator->nextBytes(10)));
    }

    /**
     * Get public_key
     *
     * @return string 
     */
    public function getPublicKey()
    {
        return $this->public_key;
    }

    /**
     * Generate private_key
     *
     * @param SecureRandom $generator
     * @return User
     */
    public function genPrivateKey($generator)
    {
        return $this->setPrivateKey(hash('md5', $generator->nextBytes(10)));
    }

    /**
     * Set private_key
     *
     * @param string $privateKey
     * @return User
     */
    public function setPrivateKey($privateKey)
    {
        $this->private_key = $privateKey;

        return $this;
    }

    /**
     * Get private_key
     *
     * @return string 
     */
    public function getPrivateKey()
    {
        return $this->private_key;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return User
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string 
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return User
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string 
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set langue
     *
     * @param string $langue
     * @return User
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return string 
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * Add applications
     *
     * @param \Datacity\PublicBundle\Entity\Application $applications
     * @return User
     */
    public function addApplication(\Datacity\PublicBundle\Entity\Application $applications)
    {
        $this->applications[] = $applications;
        $applications->setUser($this);
        return $this;
    }

    /**
     * Remove applications
     *
     * @param \Datacity\PublicBundle\Entity\Application $applications
     */
    public function removeApplication(\Datacity\PublicBundle\Entity\Application $applications)
    {
        $this->applications->removeElement($applications);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set city
     *
     * @param \Datacity\PublicBundle\Entity\City $city
     * @return User
     */
    public function setCity(\Datacity\PublicBundle\Entity\City $city = null)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get city
     *
     * @return \Datacity\PublicBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Add images
     *
     * @param \Datacity\PublicBundle\Entity\Image $images
     * @return User
     */
    public function addImage(\Datacity\PublicBundle\Entity\Image $images)
    {
        $this->images[] = $images;
        $images->setUser($this);
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Datacity\PublicBundle\Entity\Image $images
     */
    public function removeImage(\Datacity\PublicBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add news
     *
     * @param \Datacity\PublicBundle\Entity\News $news
     * @return User
     */
    public function addNews(\Datacity\PublicBundle\Entity\News $news)
    {
        $this->news[] = $news;
        $news->setUser($this);
        return $this;
    }

    /**
     * Remove news
     *
     * @param \Datacity\PublicBundle\Entity\News $news
     */
    public function removeNews(\Datacity\PublicBundle\Entity\News $news)
    {
        $this->news->removeElement($news);
    }

    /**
     * Get news
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Add sources
     *
     * @param \Datacity\PublicBundle\Entity\DSource $sources
     * @return User
     */
    public function addSource(\Datacity\PublicBundle\Entity\DSource $sources)
    {
        $this->sources[] = $sources;

        return $this;
    }

    /**
     * Remove sources
     *
     * @param \Datacity\PublicBundle\Entity\DSource $sources
     */
    public function removeSource(\Datacity\PublicBundle\Entity\DSource $sources)
    {
        $this->sources->removeElement($sources);
    }

    /**
     * Get sources
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * Add followed
     *
     * @param \Datacity\UserBundle\Entity\User $followed
     * @return User
     */
    public function addFollowed(\Datacity\UserBundle\Entity\User $followed)
    {
        $this->followed[] = $followed;

        return $this;
    }

    /**
     * Remove followed
     *
     * @param \Datacity\UserBundle\Entity\User $followed
     */
    public function removeFollowed(\Datacity\UserBundle\Entity\User $followed)
    {
        $this->followed->removeElement($followed);
    }

    /**
     * Get followed
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFollowed()
    {
        return $this->followed;
    }

    /**
     * Add followers
     *
     * @param \Datacity\UserBundle\Entity\User $followers
     * @return User
     */
    public function addFollower(\Datacity\UserBundle\Entity\User $followers)
    {
        $this->followers[] = $followers;

        return $this;
    }

    /**
     * Remove followers
     *
     * @param \Datacity\UserBundle\Entity\User $followers
     */
    public function removeFollower(\Datacity\UserBundle\Entity\User $followers)
    {
        $this->followers->removeElement($followers);
    }

    /**
     * Get followers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * Add files
     *
     * @param \Datacity\PublicBundle\Entity\File $files
     * @return User
     */
    public function addFile(\Datacity\PublicBundle\Entity\File $files)
    {
        $this->files[] = $files;

        return $this;
    }

    /**
     * Remove files
     *
     * @param \Datacity\PublicBundle\Entity\File $files
     */
    public function removeFile(\Datacity\PublicBundle\Entity\File $files)
    {
        $this->files->removeElement($files);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Add datasetOwned
     *
     * @param \Datacity\PublicBundle\Entity\Dataset $datasetOwned
     * @return User
     */
    public function addDatasetOwned(\Datacity\PublicBundle\Entity\Dataset $datasetOwned)
    {
        $this->datasetOwned[] = $datasetOwned;

        return $this;
    }

    /**
     * Remove datasetOwned
     *
     * @param \Datacity\PublicBundle\Entity\Dataset $datasetOwned
     */
    public function removeDatasetOwned(\Datacity\PublicBundle\Entity\Dataset $datasetOwned)
    {
        $this->datasetOwned->removeElement($datasetOwned);
    }

    /**
     * Get datasetOwned
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatasetOwned()
    {
        return $this->datasetOwned;
    }

    /**
     * Add datasetContributed
     *
     * @param \Datacity\PublicBundle\Entity\Dataset $datasetContributed
     * @return User
     */
    public function addDatasetContributed(\Datacity\PublicBundle\Entity\Dataset $datasetContributed)
    {
        $this->datasetContributed[] = $datasetContributed;

        return $this;
    }

    /**
     * Remove datasetContributed
     *
     * @param \Datacity\PublicBundle\Entity\Dataset $datasetContributed
     */
    public function removeDatasetContributed(\Datacity\PublicBundle\Entity\Dataset $datasetContributed)
    {
        $this->datasetContributed->removeElement($datasetContributed);
    }

    /**
     * Get datasetContributed
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDatasetContributed()
    {
        return $this->datasetContributed;
    }
}
