<?php

namespace BackOffice\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AnnuaireBundle\Entity\JointNotif;

class ForumController extends Controller

{
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        
        $users = count($em->getRepository('UserBundle:User')->findAll());
        $comments = count($em->getRepository('AnnuaireBundle:Comment')->findAll());
        $subjects = count($em->getRepository('AnnuaireBundle:Subject')->findAll());
        $themes = count($em->getRepository('AnnuaireBundle:Themes')->findAll());
        
        $maxPerPage = 10;
        $subjectslist = $em->getRepository('AnnuaireBundle:Subject')->findInArray($page, $maxPerPage);
        
        $subjects_array = array();
        
        foreach ($subjectslist as $s) {
            $subjects_array[] = array(
                'id' => $s->getId(),
                'title' => $s->getTitle(),
                'core' => $s->getCore(),
                'date' => $s->getDate(),
                'isdisabled' => $s->getIsdisabled(),
                'user' => $s->getIduser()->getUsername(),
                'theme' => $s->getTheme()->getName()
            );
        }

        $i = 0;
        while (count($subjects_array) > $i) {
            $subjects_array[$i]['nbposts'] = count($em->getRepository('AnnuaireBundle:Comment')->findNbPosts($subjects_array[$i]['id']));
            $i++;
        }
        
        $pagination = array('page' => $page,
            'route' => 'backend_forum_index',
            'pages_count' => ceil(count($subjectslist) / $maxPerPage),
            'route_params' => array()
        );
        
        return $this->render('@BackOfficeBack/Forum/index.html.twig', array(
            'subjectslist' => $subjects_array,
            'pagination' => $pagination,
            'users' => $users,
            'comments' => $comments,
            'subjects' => $subjects,
            'themes' => $themes,
        ));
    }
    
    public function changeStatusBlockAction($id)
    {    
        $em = $this->getDoctrine()->getManager();

        $output_val = $em->getRepository("AnnuaireBundle:Subject")->switchStateBlock($id);
        $subject = $em->getRepository("AnnuaireBundle:Subject")->find($id);

        if($output_val == true){
            $entity = new JointNotif();
            $entity->setUser($em->getRepository("UserBundle:User")->find($subject->getIduser()->getId()));
            $entity->setSubject($subject);
            $entity->setSee(FALSE);
            $em->persist($entity);
            $em->flush();
        }else{
            $entity = $em->getRepository("AnnuaireBundle:JointNotif")->findBy(array('subject' => $id));
            $x = $em->getRepository("AnnuaireBundle:JointNotif")->find($entity[0]->getId());
            $em->remove($x);
            $em->flush();
        }
        
        return new Response($output_val);
    }
    
}
