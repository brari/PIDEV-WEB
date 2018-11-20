<?php

namespace AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="prixpro", type="string", length=200, nullable=false)
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
     * @ORM\Column(name="image", type="string", length=200, nullable=false)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="idpat", type="integer", nullable=false)
     */
    private $idpat;


}

