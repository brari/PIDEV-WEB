<?php

namespace AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=50, nullable=false)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=50, nullable=false)
     */
    private $statut;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_reclamant", type="integer", nullable=false)
     */
    private $idReclamant;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="string", length=100, nullable=true)
     */
    private $reponse;

    /**
     * @var string
     *
     * @ORM\Column(name="decision", type="string", length=50, nullable=true)
     */
    private $decision;

    /**
     * @var string
     *
     * @ORM\Column(name="objet", type="string", length=50, nullable=false)
     */
    private $objet;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_concerne", type="integer", nullable=false)
     */
    private $idConcerne;


}

