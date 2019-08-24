<?php

namespace EvenementBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Entity\User;



/**
 * Evenements
 *
 * @ORM\Table(name="evenements")
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\EvenementRepository")

 */
class Evenements
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idevent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ide;


    /**
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id" )
     */
    private $user_id;


    /**
     * @var string
     * @ORM\Column(name="nom_E", type="string", length=100)
     */

    private $nomE;

    /**
     * @var string
     *
     * @ORM\Column(name="description_E", type="string", length=200, nullable=false)
     */
    private $descriptionE;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_E", type="string", length=200, nullable=false)
     */
    private $adresseE;

    /**
     * @var string
     *
     * @ORM\Column(name="type_E", type="string", length=200, nullable=false)
     */
    private $typeE;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_E", type="date", nullable=false)
     */
    private $dateE;

    /**
     * @var string
     *
     * @ORM\Column(name="image_E", type="string", length=200, nullable=false)
     */
    private $imageE;

    /**
     * @var int
     *
     * @ORM\Column(name="interesses", type="integer")
     */
    private $interesses;

    /**
     * @var int
     *
     * @ORM\Column(name="capacite", type="integer")
     */
    private $capacite;

    /**
     * Get idE
     *
     * @return int
     */
    public function getIdE()
    {
        return $this->ide;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNomE()
    {
        return $this->nomE;
    }

    /**
     * Get user_id
     *
     * @return int
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUser_id($user_id)
    {
        $this->user_id= $user_id;
    }

    /**
     * Get user_id
     *
     * @return int
     */
    public function getUserid()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserid($user_id)
    {
        $this->user_id= $user_id;
    }



    /**
     * Get description
     *
     * @return string
     */
    public function getDescriptionE()
    {
        return $this->descriptionE;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresseE()
    {
        return $this->adresseE;
    }
    /**
     * Get adresse
     *
     * @return string
     */
    public function getTypeE()
    {
        return $this->typeE;
    }

    /**
     * Get date
     *
     * @return date
     */
    public function getDateE()
    {
        return $this->dateE;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImageE()
    {
        return $this->imageE;
    }

    /**
     * Get capacite
     *
     * @return int
     */
    public function getCapacite()
    {
        return $this->capacite;
    }

    /**
     * Get interesses
     *
     * @return int
     */
    public function getInteresses()
    {
        return $this->interesses;
    }

    /**
     * Set nom
     *
     * @param string $nom_E
     *
     * @return Evenements
     */
    public function setNomE($nomE)
    {
        $this->nomE = $nomE;

        return $this;
    }

    /**
     * Set description
     *
     * @param string $description_E
     *
     * @return Evenements
     */
    public function setDescriptionE($descriptionE)
    {
        $this->descriptionE = $descriptionE;

        return $this;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Evenements
     */
    public function setAdresseE($adresseE)
    {
        $this->adresseE = $adresseE;

        return $this;
    }
    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Evenements
     */
    public function setTypeE($typeE)
    {
        $this->typeE = $typeE;

        return $this;
    }


    /**
     * Set date
     *
     * @param string $date_E
     *
     * @return Evenements
     */
    public function setDateE($dateE)
    {
        $this->dateE = $dateE;

        return $this;
    }

    /**
     * Set image
     *
     * @param string $image_E
     *
     * @return Evenements
     */
    public function setImageE($imageE)
    {
        $this->imageE = $imageE;

        return $this;
    }


    /**
     * Set interesses
     *
     * @param int $interesses
     *
     * @return Evenements
     */
    public function setInteresses($interesses)
    {
        $this->interesses = $interesses;

        return $this;
    }

    /**
     * Set capacite
     *
     * @param int $capacite
     *
     * @return Evenements
     */
    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;

        return $this;
    }










}

