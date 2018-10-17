<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="ranking")
 */
class Ranking
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
     * @ORM\Column(name="category", type="string", length=20, nullable=false)
     */
    private $category;


    /**
     * Set category
     *
     * @param string $category
     * @return Notice
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @var string
     * @ORM\Column(name="points", type="integer", length=5, nullable=false)
     */
    private $points;


    /**
     * Set points
     *
     * @param string $points
     * @return Notice
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getPoints()
    {
        return $this->points;
    }


    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="ranking")
     * @ORM\JoinColumn(nullable=true)
     */
    private $player;
    public function getPlayer()
    {
        return $this->player;
    }
    public function setPlayer(Player $player)
    {
        $this->player = $player;
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