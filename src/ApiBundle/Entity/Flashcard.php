<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiBundle\Entity\Stack;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Flashcard
 *
 * @ORM\Table(name="flashcard")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\FlashcardRepository")
 * @ExclusionPolicy("all")
 */
class Flashcard
{
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
     *
     * @ORM\Column(name="content", type="string", length=255)
     * @Expose
     */
    private $content;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Stack", inversedBy="flashcards")
     */
    private $stack;

    /**
     * @Expose
     */
    private $tmpId;


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
     * Set content
     *
     * @param string $content
     * @return Flashcard
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }



    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set stack
     *
     * @return Flashcard
     */
    public function setStack(Stack $stack)
    {
        $this->stack = $stack;

        return $this;
    }

    /**
     * Get stack
     *
     * @return Stack
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * Get tmpId
     */
    public function getTmpId()
    {
        return $this->tmpId;
    }

    /**
     * Set tmpId
     */
    public function setTmpId($tmpId)
    {
        $this->tmpId = $tmpId;
    }
}
