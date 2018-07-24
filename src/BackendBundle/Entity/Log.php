<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="log")
 */
class Log
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
     * @ORM\Column(name="type", type="string", length=10, nullable=false)
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
     * @var string
     * @ORM\Column(name="entity", type="string", length=25, nullable=false)
     */
    private $entity;


    /**
     * Set entity
     *
     * @param string $entity
     * @return Notice
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getEntity()
    {
        return $this->entity;
    }

       /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="log")
     * @ORM\JoinColumn(nullable=true)
     */
     private $user;
     public function getUser()
     {
         return $this->user;
     }
     public function setUser(User $user)
     {
         $this->user = $user;
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


     public function createLog($type,$entity,$user){
        $title = "";
        if($type == "new"){
            $title = $user->getUsername(). " ha creado un ".$entity;
        }
        if($type == "edit"){
            $title = $user->getUsername(). " ha modificado un ".$entity;
        }
        if($type == "delete"){
            $title = $user->getUsername(). " ha eliminado un ".$entity;
        }
        
        $log = new Log();
        $log->setType($type);
        $log->setUser($user);
        $log->setEntity($entity);
        $log->setTitle($title);

        return $log;
    }
         







}