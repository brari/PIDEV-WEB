<?php

namespace AnnuaireBundle\Entity;

/**
 * ThemesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ThemesRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllArray(){
        
        $qb = $this->createQueryBuilder('t')
            ->select('t')            
            ->getQuery();
        return $qb->getArrayResult();
    }
}
