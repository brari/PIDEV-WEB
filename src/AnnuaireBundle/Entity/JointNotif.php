<?php

namespace AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JointNotif
 *
 * @ORM\Table(name="joint_notif", indexes={@ORM\Index(name="FK_5FB6DEC723EDC8711", columns={"subject"}), @ORM\Index(name="FK_5FB6DEC7FE6E88D711", columns={"user"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AnnuaireBundle\Entity\JointNotifRepository")
 */
class JointNotif
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="see", type="boolean", nullable=false)
     */
    private $see;

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
     *   @ORM\JoinColumn(name="subject", referencedColumnName="id")
     * })
     */
    private $subject;

    /**
     * @var \UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return JointNotif
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set subject
     *
     * @param \AnnuaireBundle\Entity\Subject $subject
     *
     * @return JointNotif
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
     * Set see
     *
     * @param integer $see
     *
     * @return JointNotif
     */
    public function setSee($see)
    {
        $this->see = $see;

        return $this;
    }

    /**
     * Get see
     *
     * @return integer
     */
    public function getSee()
    {
        return $this->see;
    }
}
