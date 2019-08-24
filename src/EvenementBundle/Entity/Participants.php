<?php

namespace EvenementBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Participants
 *
 * @ORM\Table(name="participants")
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\ParticipantRepository")

 */
class Participants

{
    /**
     * @var integer
     * @ORM\Column(name="idParticipation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idParticipation;

    /**
     *
     * @ORM\ManyToOne(targetEntity="EvenementBundle\Entity\Evenements")
     * @ORM\JoinColumn(name="even_id", referencedColumnName="idevent" )
     */
    private $even;


    /**
     * @return mixed
     */
    public function getEven()
    {
        return $this->even;
    }

    /**
     * @param mixed $event
     */
    public function setEven($even)
    {
        $this->even = $even;
    }


    /**
     * Set id_participation
     *
     * @param integer $idParticipation
     *
     * @return participants
     */
    public function setidParticipation($idParticipation)
    {
        $this->idParticipation = $idParticipation;

        return $this;
    }

    /**
     * Get idParticipation
     *
     * @return int
     */
    public function getidParticipation()
    {
        return $this->idParticipation;
    }

}
