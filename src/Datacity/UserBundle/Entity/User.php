<?php

namespace Datacity\UserBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Util\SecureRandom;
use JMS\Serializer\Annotation as Serializer;

/**
 * User
 *
 * @ORM\Table(name="datacity_user")
 * @ORM\Entity(repositoryClass="Datacity\UserBundle\Entity\UserRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Serializer\Annotation\Type("integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=50)
     * @Serializer\Type("string")
     * @Serializer\Expose
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
     * @Serializer\Type("string")
     * @Serializer\Expose
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
     * @var boolean
     *
     * @ORM\Column(name="receive_newsletter", type="boolean")
     * @Serializer\Type("boolean")
     * @Serializer\Expose
     *
     */
    private $receiveNewsletter = true;

     /**
     * @var integer
     *
     * @ORM\Column(name="point", type="integer")
     * @Serializer\Type("integer")
     * @Serializer\Expose
     */

    private $point = 0;

      /**
     * @var string
     *
     * @ORM\Column(name="public_key", type="string", length=50, nullable=false)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */

    private $public_key;

      /**
     * @var string
     *
     * @ORM\Column(name="private_key", type="string", length=50, nullable=false)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */

    private $private_key;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=50, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */

    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=45, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */

    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="langue", type="string", length=45, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */

    private $langue;

    /**
     * @var string
     *
     * @ORM\Column(name="occupation", type="string", length=100, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */

    private $occupation;

    /**
     * @var string
     *
     * @ORM\Column(name="about", type="text", nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */

    private $about;

    /**
     * @var string
     *
     * @ORM\Column(name="website_url", type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */

    private $websiteUrl;

    /**
     * @var \Date
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="join_date", type="date")
     * @Serializer\Type("DateTime")
     * @Serializer\Expose
     */
    private $joinDate;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Application", mappedBy="user", cascade={"remove", "persist"})
     * @Serializer\Type("Datacity\PublicBundle\Entity\Application")
     * @Serializer\Expose
     */

    private $applications;

    /**
     * @ORM\ManyToOne(targetEntity="Datacity\PublicBundle\Entity\City", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Serializer\Type("Datacity\PublicBundle\Entity\City")
     * @Serializer\Expose
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity="Datacity\PublicBundle\Entity\Image")
     * @Serializer\Type("Datacity\PublicBundle\Entity\Image")
     * @Serializer\Expose
     */
    private $profileImg;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\News", mappedBy="user", cascade={"persist"})
     * @Serializer\Type("Datacity\PublicBundle\Entity\News")
     */
    private $news;

     /**
     * @ORM\OneToMany(targetEntity="Datacity\PrivateBundle\Entity\Ticket", mappedBy="author", cascade={"persist"})
     * @Serializer\Type("Datacity\PrivateBundle\Entity\Ticket")
     */
    private $ticketAuthor;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PrivateBundle\Entity\Ticket", mappedBy="assignedUser", cascade={"persist"})
     * @Serializer\Type("Datacity\PrivateBundle\Entity\Ticket")
     */
    private $ticketAssignedUser;


    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\DSource", mappedBy="creator", cascade={"persist"})
     * @Serializer\Type("Datacity\PublicBundle\Entity\DSource")
     */
    private $sources;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="followers")
     * @ORM\JoinTable(name="user_followers",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="follower_id", referencedColumnName="id")}
     *      )
     * @Serializer\Type("Datacity\UserBundle\Entity\User")
     * @Serializer\Expose
     * @Serializer\MaxDepth(1)
     */
    private $following;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="following")
     * @Serializer\Type("Datacity\UserBundle\Entity\User")
     * @Serializer\Expose
     * @Serializer\MaxDepth(1)
     */
    private $followers;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\File", mappedBy="user", cascade={"persist"})
     * @Serializer\Type("Datacity\PublicBundle\Entity\File")
     */
    private $files;

    /**
     * @ORM\OneToMany(targetEntity="Datacity\PublicBundle\Entity\Dataset", mappedBy="creator")
     * @Serializer\Type("Datacity\PublicBundle\Entity\Dataset")
     */
    private $datasetOwned;

    /**
     * @ORM\ManyToMany(targetEntity="Datacity\PublicBundle\Entity\Dataset", mappedBy="contributors")
     * @Serializer\Type("Datacity\PublicBundle\Entity\Dataset")
     */
    private $datasetContributed;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->news = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->followed = new \Doctrine\Common\Collections\ArrayCollection();
        $this->followers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datasetOwned = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datasetContributed = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("datasetNumber")
     *
     * @return string
     */
    public function getTotalDataset()
    {
        return count($this->datasetOwned);
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

    /**
     * Set occupation
     *
     * @param string $occupation
     * @return User
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;

        return $this;
    }

    /**
     * Get occupation
     *
     * @return string
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * Set about
     *
     * @param string $about
     * @return User
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set websiteUrl
     *
     * @param string $websiteUrl
     * @return User
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    /**
     * Get websiteUrl
     *
     * @return string
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * Set joinDate
     *
     * @param \DateTime $joinDate
     * @return User
     */
    public function setJoinDate($joinDate)
    {
        $this->joinDate = $joinDate;

        return $this;
    }

    /**
     * Get joinDate
     *
     * @return \DateTime
     */
    public function getJoinDate()
    {
        return $this->joinDate;
    }

    /**
     * Add following
     *
     * @param \Datacity\UserBundle\Entity\User $following
     * @return User
     */
    public function addFollowing(\Datacity\UserBundle\Entity\User $following)
    {
        $this->following[] = $following;

        return $this;
    }

    /**
     * Remove following
     *
     * @param \Datacity\UserBundle\Entity\User $following
     */
    public function removeFollowing(\Datacity\UserBundle\Entity\User $following)
    {
        $this->following->removeElement($following);
    }

    /**
     * Get following
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFollowing()
    {
        return $this->following;
    }

    /**
     * Set profileImg
     *
     * @param \Datacity\PublicBundle\Entity\Image $profileImg
     * @return User
     */
    public function setProfileImg(\Datacity\PublicBundle\Entity\Image $profileImg = null)
    {
        $this->profileImg = $profileImg;

        return $this;
    }

    /**
     * Get profileImg
     *
     * @return \Datacity\PublicBundle\Entity\Image
     */
    public function getProfileImg()
    {
        return $this->profileImg;
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
     * Set receiveNewsletter
     *
     * @param boolean $receiveNewsletter
     * @return User
     */
    public function setReceiveNewsletter($receiveNewsletter)
    {
        $this->receiveNewsletter = $receiveNewsletter;

        return $this;
    }

    /**
     * Get receiveNewsletter
     *
     * @return boolean 
     */
    public function getReceiveNewsletter()
    {
        return $this->receiveNewsletter;
    }

    /**
     * Add ticketAuthor
     *
     * @param \Datacity\PrivateBundle\Entity\Ticket $ticketAuthor
     * @return User
     */
    public function addTicketAuthor(\Datacity\PrivateBundle\Entity\Ticket $ticketAuthor)
    {
        $this->ticketAuthor[] = $ticketAuthor;

        return $this;
    }

    /**
     * Remove ticketAuthor
     *
     * @param \Datacity\PrivateBundle\Entity\Ticket $ticketAuthor
     */
    public function removeTicketAuthor(\Datacity\PrivateBundle\Entity\Ticket $ticketAuthor)
    {
        $this->ticketAuthor->removeElement($ticketAuthor);
    }

    /**
     * Get ticketAuthor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTicketAuthor()
    {
        return $this->ticketAuthor;
    }

    /**
     * Add ticketAssignedUser
     *
     * @param \Datacity\PrivateBundle\Entity\Ticket $ticketAssignedUser
     * @return User
     */
    public function addTicketAssignedUser(\Datacity\PrivateBundle\Entity\Ticket $ticketAssignedUser)
    {
        $this->ticketAssignedUser[] = $ticketAssignedUser;

        return $this;
    }

    /**
     * Remove ticketAssignedUser
     *
     * @param \Datacity\PrivateBundle\Entity\Ticket $ticketAssignedUser
     */
    public function removeTicketAssignedUser(\Datacity\PrivateBundle\Entity\Ticket $ticketAssignedUser)
    {
        $this->ticketAssignedUser->removeElement($ticketAssignedUser);
    }

    /**
     * Get ticketAssignedUser
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTicketAssignedUser()
    {
        return $this->ticketAssignedUser;
    }
}
