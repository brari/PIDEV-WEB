<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 16/11/2018
 * Time: 07:27
 */

namespace AnnuaireBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class NavigationController extends Controller
{
    public function redirectionAction(){
        $authChecker = $this->container->get('security.authorization_checker');
        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('interface_principal');
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
        return $this->render('@Annuaire/Default/index.html.twig');
    }
    public function patisseriesAction()
    {
        return $this->render('@Annuaire/Navigation/patisseries.html.twig');
    }

    public function evenementAction()
    {
        return $this->render('@Annuaire/Navigation/evenement.html.twig');
    }
    public function forumAction()
    {
        return $this->render('@Annuaire/Navigation/forum.html.twig');
    }
}