<?php

namespace AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="idpro", type="integer", nullable=false)
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
     *
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
     * @ORM\Column(name="image", type="string", length=200, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=200, nullable=false)
     */
    private $date;


}

