<?php

namespace FrontOffice\ForumBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ForumController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $themes = $em->getRepository('AnnuaireBundle:Themes')->findAllArray();

        $nbnotif = count($em->getRepository('AnnuaireBundle:JointNotif')->getNotifNotSee($this->get('security.token_storage')->getToken()->getUser()->getId()));

        $messages = 0;
        $sujets = 0;
        $users = count($em->getRepository('UserBundle:User')->findAll());


        if ($this->get('security.token_storage')->getToken()->getUser() != 'anon.') {
            $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        } else {
            $user = 0;
        }
        
        $i = 0;
        while (count($themes) > $i) {
            $subjects = $em->getRepository('AnnuaireBundle:Subject')->findBy(array('theme' => $themes[$i]['id']));
            $posts = $em->getRepository('AnnuaireBundle:Comment')->findBy(array('theme' => $themes[$i]['id']));
            $themes[$i]['subjects'] = count($subjects);
            $themes[$i]['posts'] = count($posts);
            $themes[$i]['lastSubject'] = $em->getRepository('AnnuaireBundle:Subject')->findLastSubject($themes[$i]['id']);
            $messages += count($posts);
            $sujets += count($subjects);
            $i++;
        }


        $stats = array('messages' => count($em->getRepository('AnnuaireBundle:Comment')->findAll()),
            'sujets' => count($em->getRepository('AnnuaireBundle:Subject')->findAll()),
            'users' => $users,
            'sujetsParJr' => count($em->getRepository('AnnuaireBundle:Subject')->findBySujetsParJr(date('Y-m-d'))),
            'messagesParJr' => count($em->getRepository('AnnuaireBundle:Comment')->findBymessagesParJr(date('Y-m-d'))),
            'usersParJr' => count($em->getRepository('UserBundle:User')->findByusersParJr(date('Y-m-d'))),
            'sujetsParVous' => count($em->getRepository('AnnuaireBundle:Subject')->findBy(array('iduser' => $user))),
            'messagesParVous' => count($em->getRepository('AnnuaireBundle:Comment')->findBy(array('iduser' => $user)))
        );

        return $this->render('@FrontOfficeForum/Forum/index.html.twig', array(
                    'themes' => $themes,
                    'stats' => $stats,
                    'nbnotif' => $nbnotif));
    }

    public function notifAction() {
        $em = $this->getDoctrine()->getManager();

        $subjects = $em->getRepository('AnnuaireBundle:JointNotif')->getBlocked($this->get('security.token_storage')->getToken()->getUser()->getId());
        $s = array();
        foreach ($subjects as $value) {
            $value->setSee(true);
            $em->persist($value);
            $s[] = $em->getRepository('AnnuaireBundle:Subject')->find($value->getSubject());
        }
        $em->flush();

        if ($this->get('security.token_storage')->getToken()->getUser() != 'anon.') {
            $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        } else {
            $user = 0;
        }

        return $this->render('@FrontOfficeForumBundle/MySubjects/notif.html.twig', array(
                    'subjects' => $s,
        ));
    }

}
