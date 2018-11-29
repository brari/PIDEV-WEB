<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 26/11/2018
 * Time: 22:50
 */

namespace PatisserieBundle\Repository;


use Doctrine\ORM\EntityRepository;

class PatisserieRepository extends EntityRepository
{
    public function findPatisserie($nom){
        $query=$this->getEntityManager()
            ->createQuery("SELECT p FROM PatisserieBundle:Patisserie p WHERE p.nom LIKE :nom ORDER BY p.nom ASC")
            ->setParameter('nom','%'.$nom.'%');
        return $query->getResult();
    }

    public function findMaPatisserie($nom, $id){
        $query=$this->getEntityManager()
            ->createQuery("SELECT p FROM PatisserieBundle:Patisserie p WHERE p.nom LIKE :nom AND p.idp=:id ORDER BY p.nom ASC")
            ->setParameters(array('nom'=>'%'.$nom.'%','id'=>$id));
        return $query->getResult();
    }

    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM PatisserieBundle:Patisserie p ORDER BY p.nom ASC'
            )
            ->getResult();
    }

    public function findAllOrderedByRating()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM PatisserieBundle:Patisserie p ORDER BY p.rating ASC'
            )
            ->getResult();
    }

    public function mesPatisseries($id){
        $query=$this->getEntityManager()
            ->createQuery("SELECT p FROM PatisserieBundle:Patisserie p WHERE p.idprop= :id ORDER BY p.nom ASC")
            ->setParameter('id',$id);
        return $query->getResult();
    }

}