<?php
namespace BackendBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="event")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
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
     * @var string
     * @ORM\Column(name="title", type="string", length=50, nullable=false)
     */
    private $title;
     /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @var string
     * @ORM\Column(name="recaudation", type="integer", nullable=true)
     */
     private $recaudation;
     /**
     * Set recaudation
     *
     * @param string $recaudation
     */
    public function setRecaudation($recaudation)
    {
        $this->recaudation = $recaudation;
        return $this;
    }
    /**
     * Get recaudation
     *
     * @return string 
     */
    public function getRecaudation()
    {
        return $this->recaudation;
    }
   
    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;
     /**
     * Set type
     *
     * @param string $type
     * @return Match
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @ORM\Column(name="date_match", type="date")
     */
    private $dateMatch;
    public function getDateMatch()
    {
        return $this->dateMatch;
    }
    public function setDateMatch($dateMatch)
    {
        $this->dateMatch = $dateMatch;
        return $this;
    }

    /**
     * @var float
     * @ORM\Column(name="hours", type="float", length=3, nullable=false)
     */
     private $hours;
     /**
     * Set hours
     *
     * @param float $hours
     * @return Match
     */
    public function setHours($hours)
    {
        $this->hours = $hours;
        return $this;
    }
    /**
     * Get type
     *
     * @return float 
     */
    public function getHours()
    {
        return $this->hours;
    }
    public function getHoursString()
    {
        if($this->hours == 1)
            return "1 hora";
        if($this->hours == 2)
            return "1 hora y media";
        if($this->hours == 3)
            return "2 horas";
        if($this->hours == 4)
            return "2 horas y media";
        if($this->hours == 5)
            return "3 horas";
            
    }

    /**
     * @var string
     * @ORM\Column(name="hour", type="string", nullable=false)
     */
     private $hour;
     /**
     * Set hour
     *
     * @param string $hour
     * @return Match
     */
    public function setHour($hour)
    {
        $this->hour = $hour;
        return $this;
    }
    /**
     * Get type
     *
     * @return string 
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @var boolean
     * @ORM\Column(name="is_suspended", type="boolean", nullable=true)
     */
     private $isSuspended;
     /**
     * Set isSuspended
     *
     * @param boolean $isSuspended
     * @return Match
     */
    public function setIsSuspended($isSuspended)
    {
        $this->isSuspended = $isSuspended;
        return $this;
    }
    /**
     * Get isSuspended
     *
     * @return boolean 
     */
    public function getIsSuspended()
    {
        return $this->isSuspended;
    }

   /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;
    
   /**
   * @var \DateTime
   *
   * @ORM\Column(name="update_at", type="datetime")
   */
   private $updateAt;
   /**
    * Set createAt
    *
    * @param \DateTime $createAt
    * @return Shows
    */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;
        return $this;
    }
    /**
     * Get createAt
     *
     * @return \DateTime 
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }
    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Artistas
     * @ORM\PreUpdate 
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;
        return $this;
    }
    /**
     * Get updateAt
     *
     * @return \DateTime 
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }
    /**
    * @ORM\PrePersist
    */
    public function setCreateAtValue(){
        $this->createAt = new \DateTime();
    }
    
    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function setUpdateAtValue(){
        $this->updateAt = new \DateTime();
    }
    
}