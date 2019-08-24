<?php

namespace AnnuaireBundle\Entity;

/**
 * commentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function findBymessagesParJr($date){
        $qb = $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.date like :date')
            ->setParameter(':date', '%'.$date.'%')
            ->getQuery();
    return $qb->getResult();
    }
    
    public function findLastComment($id_subject, $id_theme){
        $qb = $this->createQueryBuilder('c')
                ->select('c')
                ->where('c.subject = :id_subject and c.theme = :id_theme')
                ->setParameter(':id_subject', $id_subject)
                ->setParameter(':id_theme', $id_theme)
                ->orderBy('c.date', 'DESC')
                ->setMaxResults(1)
                ->getQuery();
        return $qb->getResult();
    }
    
    public function findNbPosts($subject){
        $qb = $this->createQueryBuilder('c')
                ->select('c')
                ->where('c.subject = :subject')
                ->setParameter(':subject', $subject)
                ->getQuery();
        return $qb->getResult();
    }
    
    public function findByDate($date){
        $qb = $this->createQueryBuilder('c')
                ->where('c.date like :date')
                ->setParameter('date', '%'.$date.'%')
                ->getQuery();
        return $qb->getResult();
    }
    
    public function findByUser($user){
        $qb = $this->createQueryBuilder('c')
                ->where('c.iduser = :user')
                ->setParameter('user', $user)
                ->getQuery();
        return $qb->getResult();
    }
}