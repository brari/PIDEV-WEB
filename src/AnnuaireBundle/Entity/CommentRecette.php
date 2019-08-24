<?php

namespace AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * CommentRecette
 *
 * @ORM\Table(name="comment_recette", indexes={@ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="recette_id", columns={"recette_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AnnuaireBundle\Entity\CommentRecetteRepository")
 */
class CommentRecette
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
     * @var \AnnuaireBundle\Entity\Recette
     *
     * @ORM\ManyToOne(targetEntity="AnnuaireBundle\Entity\Recette")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recette_id", referencedColumnName="id")
     * })
     */
    private $recette;

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
     * Set recette
     *
     * @param \AnnuaireBundle\Entity\Recette $recette
     *
     * @return Comment
     */
    public function setRecette(\AnnuaireBundle\Entity\Recette $recette = null)
    {
        $this->recette = $recette;

        return $this;
    }

    /**
     * Get recette
     *
     * @return \AnnuaireBundle\Entity\Recette
     */
    public function getRecette()
    {
        return $this->recette;
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
