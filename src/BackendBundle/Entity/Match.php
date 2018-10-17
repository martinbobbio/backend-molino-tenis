<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="matchs")
 */
class Match
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
     * @ORM\Column(name="title", type="string", length=40, nullable=false)
     */
    private $title;


    /**
     * Set title
     *
     * @param string $title
     * @return Notice
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
     * @ORM\Column(name="score", type="string", length=20, nullable=false)
     */
    private $score;


    /**
     * Set score
     *
     * @param string $score
     * @return Notice
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return string 
     */
    public function getScore()
    {
        return $this->score;
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
     * @var string
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     */
    private $type;


    /**
     * Set type
     *
     * @param string $type
     * @return Notice
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
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="matchs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $playerWin;
    public function getPlayerWin()
    {
        return $this->playerWin;
    }
    public function setPlayerWin(Player $playerWin)
    {
        $this->playerWin = $playerWin;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="matchs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $playerLoss;
    public function getPlayerLoss()
    {
        return $this->playerLoss;
    }
    public function setPlayerLoss(Player $playerLoss)
    {
        $this->playerLoss = $playerLoss;
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