<?php

namespace FeteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fete
 *
 * @ORM\Table(name="fete", indexes={@ORM\Index(name="idUser", columns={"idUser"})})
 * @ORM\Entity
 */
class Fete
{
    /**
     * @return int
     */
    public function getIdf()
    {
        return $this->idf;
    }

    /**
     * @return string
     */
    public function getNomF()
    {
        return $this->nomF;
    }

    /**
     * @param string $nomF
     */
    public function setNomF($nomF)
    {
        $this->nomF = $nomF;
    }

    /**
     * @return string
     */
    public function getDescriptionF()
    {
        return $this->descriptionF;
    }

    /**
     * @param string $descriptionF
     */
    public function setDescriptionF($descriptionF)
    {
        $this->descriptionF = $descriptionF;
    }

    /**
     * @return string
     */
    public function getAdresseF()
    {
        return $this->adresseF;
    }

    /**
     * @param string $adresseF
     */
    public function setAdresseF($adresseF)
    {
        $this->adresseF = $adresseF;
    }

    /**
     * @return \DateTime
     */
    public function getDateF()
    {
        return $this->dateF;
    }

    /**
     * @param \DateTime $dateF
     */
    public function setDateF($dateF)
    {
        $this->dateF = $dateF;
    }

    /**
     * @return int
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param int $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    /**
     * @param int $idf
     */
    public function setIdf($idf)
    {
        $this->idf = $idf;
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="idF", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idf;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_F", type="string", length=50, nullable=false)
     */
    private $nomF;

    /**
     * @var string
     *
     * @ORM\Column(name="description_F", type="string", length=50, nullable=false)
     */
    private $descriptionF;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_F", type="string", length=50, nullable=false)
     */
    private $adresseF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_F", type="date", nullable=false)
     */
    private $dateF;

    /**
     * @var integer
     *
     * @ORM\Column(name="idUser", type="integer", nullable=false)
     */
    private $iduser;


}

