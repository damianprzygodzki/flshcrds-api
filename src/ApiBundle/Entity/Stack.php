<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use ApiBundle\Entity\User;

/**
 * Stack
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="stack")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\StackRepository")
 */
class Stack
{
    public function generateRandom(){
       $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $randomString = '';

       for ($i = 0; $i < 6; $i++) {
           $randomString .= $characters[rand(0, strlen($characters) - 1)];
       }

       return $randomString;
    }
    public function __construct() {
        $this->flashcards = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     */
     public function setInitialProps() {
         $this->uri = $this->generateRandom();
     }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Flashcard", mappedBy="stack")
     */
    private $flashcards;

    /**
     * @var string
     * @ORM\Column(name="uri", type="string", unique=true)
     */
     private $uri;

     /**
      * @var User
      * @ORM\ManyToOne(targetEntity="User", inversedBy="stacks")
      */
      private $user;

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
      * Get uri
      *
      * @return string
      */
     public function getUri()
     {
         return $this->uri;
     }

     /**
      * Set uri
      *
      * @return Stack
      */
     public function setUri($uri)
     {
         $this->uri = $uri;

         return $this;
     }
     /**
      * Get user
      *
      * @return User
      */
     public function getUser()
     {
         return $this->user;
     }

     /**
      * Set User
      *
      * @return Stack
      */
     public function setUser($user)
     {
         $this->user = $user;

         return $this;
     }

    /**
     * Set flashcards
     *
     * @param array $flashcards
     * @return Stack
     */
    public function setFlashcards($flashcards)
    {
        $this->flashcards = $flashcards;

        return $this;
    }

    /**
     * Get flashcards
     *
     * @return array
     */
    public function getFlashcards()
    {
        return $this->flashcards;
    }
}
