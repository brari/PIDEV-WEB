<?php
/**
 * Created by PhpStorm.
 * User: Bader
 * Date: 04/12/2018
 * Time: 16:41
 */

namespace AnnuaireBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * ordertab
 *
 * @ORM\Table(name="ordertab")
 * @ORM\Entity
 */
class ordertab
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idu", type="integer", nullable=false)
     */
    private $idu;

    /**
     * @var integer
     *
     * @ORM\Column(name="idRecette", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRecette;
    /**
     * @var integer
     *
     * * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="recetteName", type="string", length=255, nullable=false)
     */
    private $recetteName;

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
    public function getIdRecette()
    {
        return $this->idRecette;
    }

    /**
     * @param int $idRecette
     */
    public function setIdRecette($idRecette)
    {
        $this->idRecette = $idRecette;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getRecetteName()
    {
        return $this->recetteName;
    }

    /**
     * @param string $recetteName
     */
    public function setRecetteName($recetteName)
    {
        $this->recetteName = $recetteName;
    }


}