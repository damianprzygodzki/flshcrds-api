<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use ApiBundle\Entity\Stack;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * User
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @ExclusionPolicy("all")
 */
class User
{
    public function __construct() {
        $this->stacks = new ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="email", type="string")
      * @Expose
     */
    private $email;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Stack", mappedBy="user")
     */
    private $stacks;

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
      * Get email
      *
      * @return string
      */
     public function getEmail()
     {
         return $this->email;
     }

     /**
      * Set email
      *
      * @return User
      */
     public function setEmail($email)
     {
         $this->email = $email;

         return $this;
     }
     /**
      * Set stacks
      *
      * @param array $stacks
      * @return User
      */
     public function setStacks($stacks)
     {
         $this->stacks = $stacks;

         return $this;
     }

     /**
      * Get stacks
      *
      * @return array
      */
     public function getStacks()
     {
         return $this->stacks;
     }
}
