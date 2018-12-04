<?php

namespace PatisserieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Patisserie
 *
 * @ORM\Table(name="patisserie", indexes={@ORM\Index(name="FK_prop", columns={"idprop"})})
 * @ORM\Entity(repositoryClass="PatisserieBundle\Repository\PatisserieRepository")
 */
class Patisserie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idp;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=50, nullable=false)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="contact", type="integer", nullable=false)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=50, nullable=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=200, nullable=true)
     */
    private $url;

    /**
     * @var float
     *
     * @ORM\Column(name="rating", type="float", precision=10, scale=0, nullable=true)
     */
    private $rating;

    /**
     * @var boolean
     *
     * @ORM\Column(name="reservation", type="boolean", nullable=false)
     */
    private $reservation;

    /**
     * @var integer
     *
     * @ORM\Column(name="place", type="integer", nullable=true)
     */
    private $place;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idprop", referencedColumnName="id")
     * })
     */
    private $idprop;

    /**
     * @return int
     */
    public function getIdp()
    {
        return $this->idp;
    }


    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @return int
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param int $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return int
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param int $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return \User
     */
    public function getIdprop()
    {
        return $this->idprop;
    }

    /**
     * @param \User $idprop
     */
    public function setIdprop($idprop)
    {
        $this->idprop = $idprop;
    }

    /**
     * @return bool
     */
    public function isReservation()
    {
        return $this->reservation;
    }

    /**
     * @param bool $reservation
     */
    public function setReservation($reservation)
    {
        $this->reservation = $reservation;
    }



}

