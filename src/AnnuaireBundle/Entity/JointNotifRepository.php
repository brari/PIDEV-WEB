<?php

namespace AnnuaireBundle\Entity;

/**
 * JointNotifRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JointNotifRepository extends \Doctrine\ORM\EntityRepository {

    public function getBySubject($subject) {
        $qb = $this->createQueryBuilder('j')
                ->where('j.subject = :subject')
                ->setParameter(':subject', $subject)
                ->getQuery();
        return $qb->getResult();
    }

    public function getNotifNotSee($user) {
        $qb = $this->createQueryBuilder('j')
                ->where('j.user = :user')
                ->andWhere('j.see = false')
                ->setParameter(':user', $user)
                ->getQuery();
        return $qb->getResult();
    }
    
    public function getBlocked($user) {
        $qb = $this->createQueryBuilder('j')
                ->where('j.user = :user')
                ->setParameter(':user', $user)
                ->getQuery();
        return $qb->getResult();
    }

}