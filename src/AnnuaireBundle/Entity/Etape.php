<?php

namespace AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etape
 *
 * @ORM\Table(name="etape", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Etape
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_eta", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEta;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_eta", type="string", length=255, nullable=false)
     */
    private $nomEta;

    /**
     * @var string
     *
     * @ORM\Column(name="description_eta", type="string", length=255, nullable=false)
     */
    private $descriptionEta;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=false)
     */
    private $idUtilisateur;


}

