<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Prods
 *
 * @ORM\Table(name="prods", indexes={@ORM\Index(name="idU", columns={"idpro", "nompro"})})
 * @ORM\Entity
 */
class Prods
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idpro", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @Assert\NotBlank(message="Please, upload an image.")
     * @Assert\Image()
     * @ORM\Column(name="image", type="string", length=200, nullable=false)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="PatisserieBundle\Entity\Patisserie")
     * @ORM\JoinColumn(name="idpat",referencedColumnName="idp",onDelete="CASCADE")
     */
    private $idpat;
    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock;

    /**
     * @return int
     */
    public function getIdpro()
    {
        return $this->idpro;
    }
    /**
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
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
     * @return int
     */
    public function getIdpat()
    {
        return $this->idpat;
    }

    /**
     * @param int $idpat
     */
    public function setIdpat($idpat)
    {
        $this->idpat = $idpat;
    }
    /**
     * @return int
     */
    public function getIdf()
    {
        return $this->idf;
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
     * @ORM\Column(name="idF", type="integer", nullable=true)
     */
    private $idf;


}

