<?php

namespace BackOffice\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller {

    public function adminAction() {
        return $this->render('Adminlayout.html.twig');
    }

    public function indextemplateAction() {
        return $this->render('@BackOfficeBack/template/index.html.twig');
    }

    public function widgetsAction() {
        return $this->render('@BackOfficeBack/template/widgets.html.twig');
    }

    public function chartsAction() {
        $em = $this->getDoctrine()->getManager();
        $labels = json_encode(['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jui', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Déc']);
        $d = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $data = array();
        foreach ($d as $value) {
            $data[] = count($em->getRepository('AnnuaireBundle:Comment')->findByDate(date("Y-$value")));
        }

        return $this->render('@BackOfficeBack/template/charts.html.twig');
    }

    public function getStatCommentAction() {
        $em = $this->getDoctrine()->getManager();
        $d = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        $data = array();
        foreach ($d as $value) {
            $data[] = count($em->getRepository('AnnuaireBundle:Comment')->findByDate(date("Y-$value")));
        }
        return new Response(json_encode($data));
    }

    public function getCommentUserAction() {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $comms = count($em->getRepository('AnnuaireBundle:Comment')->findAll());
        $data = array();

        foreach ($users as $user) {
            $c_u = $em->getRepository('AnnuaireBundle:Comment')->findByUser($user->getId());
            $data[] = array(
                'name' => $user->getUsername(),
                'y' => count($c_u)
            );
        }

        return new Response(json_encode($data));
    }
    
    public function getSubjectUserAction() {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        $subjct = count($em->getRepository('AnnuaireBundle:Subject')->findAll());
        $data = array();

        foreach ($users as $user) {
            $c_u = $em->getRepository('AnnuaireBundle:Subject')->findByUser($user->getId());
            $data[] = array(
                'name' => $user->getUsername(),
                'y' => count($c_u)
            );
        }

        return new Response(json_encode($data));
    }

    public function tablesAction() {
        return $this->render('@BackOfficeBack/template/tables.html.twig');
    }

//    public function loginAction()
//    {
//        return $this->render('BackOfficeBackBundle:template:login.html.twig');
//    }
    public function formsAction() {
        return $this->render('@BackOfficeBack/template/forms.html.twig');
    }

    public function panelsAction() {
        return $this->render('@BackOfficeBack/template/panels.html.twig');
    }

    public function iconsAction() {
        return $this->render('@BackOfficeBack/template/icons.html.twig');
    }

}
