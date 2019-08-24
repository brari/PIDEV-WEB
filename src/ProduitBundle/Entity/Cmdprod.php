<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Cmdprod
 *
 * @ORM\Table(name="cmdprod")
 * @ORM\Entity
 */
class Cmdprod
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idcp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcp;

    /**
     * @var integer
     *
     * @ORM\Column(name="idu", type="integer", nullable=false)
     */
    private $idu;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Prods")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="idpro",referencedColumnName="idpro",onDelete="CASCADE")})
     */
    private $idpro;

    /**
     * @var string
     *
     * @ORM\Column(name="nompro", type="string", length=200, nullable=false)
     */
    private $nompro;

    /**
     * @var float
     * @Assert\GreaterThan(0)
     * @ORM\Column(name="prixpro", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixpro;

    /**
     * @var string
     *
     * @ORM\Column(name="categoriepro", type="string", length=200, nullable=false)
     */
    private $categoriepro;

    /**
     * @var string
     *
     * @ORM\Column(name="detailspro", type="string", length=200, nullable=false)
     */
    private $detailspro;

    /**
     * @var string
     *
     * @ORM\Column(name="nompat", type="string", length=200, nullable=false)
     */
    private $nompat;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=200, nullable=true)
     */
    private $image;

    /**
     * @var date
     *
     * @ORM\Column(name="date", type="date", length=200, nullable=true)
     */
    private $date;

    /**
     * @return int
     */
    public function getIdcp()
    {
        return $this->idcp;
    }

    /**
     * @param int $idcp
     */
    public function setIdcp($idcp)
    {
        $this->idcp = $idcp;
    }

    /**
     * @return int
     */
    public function getIdu()
    {
        return $this->idu;
    }

    /**
     * @param int $idu
     */
    public function setIdu($idu)
    {
        $this->idu = $idu;
    }

    /**
     * @return int
     */
    public function getIdpro()
    {
        return $this->idpro;
    }

    /**
     * @param int $idpro
     */
    public function setIdpro($idpro)
    {
        $this->idpro = $idpro;
    }

    /**
     * @return string
     */
    public function getNompro()
    {
        return $this->nompro;
    }

    /**
     * @param string $nompro
     */
    public function setNompro($nompro)
    {
        $this->nompro = $nompro;
    }

    /**
     * @return float
     */
    public function getPrixpro()
    {
        return $this->prixpro;
    }

    /**
     * @param float $prixpro
     */
    public function setPrixpro($prixpro)
    {
        $this->prixpro = $prixpro;
    }

    /**
     * @return string
     */
    public function getCategoriepro()
    {
        return $this->categoriepro;
    }

    /**
     * @param string $categoriepro
     */
    public function setCategoriepro($categoriepro)
    {
        $this->categoriepro = $categoriepro;
    }

    /**
     * @return string
     */
    public function getDetailspro()
    {
        return $this->detailspro;
    }

    /**
     * @param string $detailspro
     */
    public function setDetailspro($detailspro)
    {
        $this->detailspro = $detailspro;
    }

    /**
     * @return string
     */
    public function getNompat()
    {
        return $this->nompat;
    }

    /**
     * @param string $nompat
     */
    public function setNompat($nompat)
    {
        $this->nompat = $nompat;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


}

