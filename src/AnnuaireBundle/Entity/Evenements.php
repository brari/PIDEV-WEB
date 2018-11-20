<?php

namespace AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenements
 *
 * @ORM\Table(name="evenements", indexes={@ORM\Index(name="idU", columns={"idE", "nom_E"})})
 * @ORM\Entity
 */
class Evenements
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ide;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_E", type="string", length=200, nullable=false)
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
     * @var float
     *
     * @ORM\Column(name="latitude_E", type="float", precision=10, scale=0, nullable=false)
     */
    private $latitudeE;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude_E", type="float", precision=10, scale=0, nullable=false)
     */
    private $longitudeE;


}

