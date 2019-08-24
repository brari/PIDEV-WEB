<?php

namespace AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Comment
 *
 * @ORM\Table(name="comment", indexes={@ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="subject_id", columns={"subject_id"}), @ORM\Index(name="theme_id", columns={"theme_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AnnuaireBundle\Entity\CommentRepository")
 */
class Comment
{
    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=false)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AnnuaireBundle\Entity\Subject
     *
     * @ORM\ManyToOne(targetEntity="AnnuaireBundle\Entity\Subject")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     * })
     */
    private $subject;

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
    
    public function __construct()
    {
        $this->date = new \Datetime();
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Comment
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
     * Set subject
     *
     * @param \AnnuaireBundle\Entity\Subject $subject
     *
     * @return Comment
     */
    public function setSubject(\AnnuaireBundle\Entity\Subject $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \AnnuaireBundle\Entity\Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set theme
     *
     * @param \AnnuaireBundle\Entity\Themes $theme
     *
     * @return Comment
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
     * @return Comment
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
}
