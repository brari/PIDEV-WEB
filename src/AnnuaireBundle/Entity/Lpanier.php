<?php

namespace AnnuaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recette
 *
 * @ORM\Table(name="lpanier")
 * @ORM\Entity
 */
class Lpanier
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
     * @ORM\Column(name="client", type="string", length=255, nullable=false)
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="recette", type="string", length=255, nullable=false)
     */
    private $recette;

    /**
     * @var string
     *
     * @ORM\Column(name="qt", type="integer", nullable=true)
     */
    private $qt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getRecette()
    {
        return $this->recette;
    }

    /**
     * @param string $recette
     */
    public function setRecette($recette)
    {
        $this->recette = $recette;
    }

    /**
     * @return string
     */
    public function getQt()
    {
        return $this->qt;
    }

    /**
     * @param string $qt
     */
    public function setQt($qt)
    {
        $this->qt = $qt;
    }

    /**
     * @return \DateTime
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param \DateTime $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="total", type="double", nullable=false)
     */
    private $total;







}

