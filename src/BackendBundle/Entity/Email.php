<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="emails")
 */
class Email
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     * @return Notice
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
     * @var string
     * @ORM\Column(name="phone", type="string", length=50, nullable=false)
     */
    private $phone;


    /**
     * Set phone
     *
     * @param string $phone
     * @return Notice
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }


    /**
     * @var string
     * @ORM\Column(name="subject", type="string", length=50, nullable=false)
     */
    private $subject;


    /**
     * Set subject
     *
     * @param string $subject
     * @return Notice
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }


    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;


    /**
     * Set description
     *
     * @param string $description
     * @return Notice
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