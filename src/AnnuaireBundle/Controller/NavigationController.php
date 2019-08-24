<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 16/11/2018
 * Time: 07:27
 */

namespace AnnuaireBundle\Controller;


use PatisserieBundle\Entity\Patisserie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class NavigationController extends Controller
{
    public function redirectionAction(){
        $authChecker = $this->container->get('security.authorization_checker');
        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('interface_admin');
        }
        else if($authChecker->isGranted('ROLE_PATISSIER')){
            return $this->redirectToRoute('patisserie_homepage');
        }
        else if($authChecker->isGranted('ROLE_CLIENT')){
            return $this->redirectToRoute('client_homepage');
        }
        else{
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recettes = $em->getRepository('AnnuaireBundle:Recette')->findAll();

        return $this->render('@Annuaire/Default/index.html.twig', ['recettes' => $recettes]);
    }


    public function homeeeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recettes = $em->getRepository('AnnuaireBundle:Recette')->findAll();

        return $this->render('@Annuaire/Default/index.html.twig', ['recettes' => $recettes]);
    }

    /*public function homeAction()
    {
        $patisserie = $this->getDoctrine()->getRepository(Patisserie::class)->findAll();
        return $this->render('@Annuaire/accueil.html.twig',array('patisseries' => $patisserie));
    }
    public function patisseriesAction()
    {
        return $this->render('@Annuaire/Navigation/patisseries.html.twig');
    }*/


    public function forumAction()
    {
        return $this->render('@Annuaire/Navigation/forum.html.twig');
    }
    public function feteAction()
    {
        return $this->render('fete/index.html.twig');
    }
    public function ReclamationAction()
    {
        return $this->render('reclamation/index.html.twig');
    }
}