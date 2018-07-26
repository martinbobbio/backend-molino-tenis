<?php
namespace BackendBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="spend")
 */
class Spend
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
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
     private $type;
     /**
     * Set type
     *
     * @param string $type
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
     * @var string
     * @ORM\Column(name="price", type="integer", length=5, nullable=false)
     */
     private $price;
     /**
     * Set price
     *
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @var string
     * @ORM\Column(name="total", type="integer", length=5, nullable=false)
     */
     private $total;
     /**
     * Set total
     *
     * @param string $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }
    public function generateTotal(){
        $this->total = $this->price * $this->count;
    }
    /**
     * Get total
     *
     * @return string 
     */
    public function getTotal()
    {
        return $this->total;
    }


    /**
     * @var string
     * @ORM\Column(name="count", type="integer", length=5, nullable=false)
     */
     private $count;
     /**
     * Set count
     *
     * @param string $count
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }
    /**
     * Get count
     *
     * @return string 
     */
    public function getCount()
    {
        return $this->count;
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