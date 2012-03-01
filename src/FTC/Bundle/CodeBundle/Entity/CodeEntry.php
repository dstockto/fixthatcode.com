<?php

namespace FTC\Bundle\CodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * FTC\Bundle\CodeBundle\Entity\CodeEntry
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FTC\Bundle\CodeBundle\Entity\CodeEntryRepository")
 */
class CodeEntry
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime $dateSubmited
     *
     * @ORM\Column(name="dateSubmited", type="datetime")
     */
    private $dateSubmited;

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=10)
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="pending", type="boolean")
     */
    protected $pending = true;

    /**
     * @var \FTC\Bundle\AuthBundle\Entity\User $author
     *
     * @ORM\ManyToOne(targetEntity="\FTC\Bundle\AuthBundle\Entity\User", fetch="EAGER")
     */
    protected $author;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection $snippets
     *
     * @ORM\OneToMany(targetEntity="Snippet", mappedBy="entry")
     */
    protected $snippets;

    public function __construct()
    {
        $this->dateSubmited = new \DateTime();
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
     * Set title
     *
     * @param string $title
     * @return CodeEntry
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
     * Set description
     *
     * @param text $description
     * @return CodeEntry
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateSubmited
     *
     * @param datetime $dateSubmited
     * @return CodeEntry
     */
    public function setDateSubmited($dateSubmited)
    {
        $this->dateSubmited = $dateSubmited;
        return $this;
    }

    /**
     * Get dateSubmited
     *
     * @return datetime 
     */
    public function getDateSubmited()
    {
        return $this->dateSubmited;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return CodeEntry
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
     * @param \FTC\Bundle\AuthBundle\Entity\User $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return \FTC\Bundle\AuthBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param boolean $pending
     */
    public function setPending($pending)
    {
        $this->pending = $pending;
    }

    /**
     * @return boolean
     */
    public function getPending()
    {
        return $this->pending;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $snippets
     */
    public function setSnippets($snippets)
    {
        $this->snippets = $snippets;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSnippets()
    {
        return $this->snippets;
    }

}