<?php

namespace AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Subject
 *
 * @ORM\Table(name="subject", indexes={@ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="theme_id", columns={"theme_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AnnuaireBundle\Entity\SubjectRepository")
 */
class Subject
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="core", type="text", nullable=false)
     */
    private $core;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isdisabled", type="boolean", nullable=false)
     */
    private $isdisabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isblocked", type="boolean", nullable=false)
     */
    private $isblocked;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    //    public function __construct()
//    {
//        $this->isdisabled = FALSE;
//    }

    /**
     * @var \AnnuaireBundle\Entity\Themes
     *
     * @ORM\ManyToOne(targetEntity="AnnuaireBundle\Entity\Themes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="theme_id", referencedColumnName="id")
     * })
     */
    private $theme;

    /**
     * @var \UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;

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
     *
     * @return Subject
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
     * Set core
     *
     * @param string $core
     *
     * @return Subject
     */
    public function setCore($core)
    {
        $this->core = $core;

        return $this;
    }

    /**
     * Get core
     *
     * @return string
     */
    public function getCore()
    {
        return $this->core;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Subject
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set isdisabled
     *
     * @param boolean $isdisabled
     *
     * @return Subject
     */
    public function setIsdisabled($isdisabled)
    {
        $this->isdisabled = $isdisabled;

        return $this;
    }

    /**
     * Get isdisabled
     *
     * @return boolean
     */
    public function getIsdisabled()
    {
        return $this->isdisabled;
    }

    /**
     * Set theme
     *
     * @param \AnnuaireBundle\Entity\Themes $theme
     *
     * @return Subject
     */
    public function setTheme(\AnnuaireBundle\Entity\Themes $theme = null)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return \AnnuaireBundle\Entity\Themes
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set iduser
     *
     * @param \UserBundle\Entity\User $iduser
     *
     * @return Subject
     */
    public function setIduser(\UserBundle\Entity\User $iduser = null)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return \UserBundle\Entity\User
     */
    public function getIduser()
    {
        return $this->iduser;
    }


    /**
     * Set isblocked
     *
     * @param boolean $isblocked
     *
     * @return Subject
     */
    public function setIsblocked($isblocked)
    {
        $this->isblocked = $isblocked;

        return $this;
    }

    /**
     * Get isblocked
     *
     * @return boolean
     */
    public function getIsblocked()
    {
        return $this->isblocked;
    }

}

