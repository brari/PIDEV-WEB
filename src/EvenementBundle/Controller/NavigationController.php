<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 16/11/2018
 * Time: 07:27
 */

namespace EvenementBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavigationController extends Controller
{
    public function homeAction()
    {
        return $this->render('@Evenement/Default/index.html.twig');
    }
    public function patisseriesAction()
    {
        return $this->render('@Evenement/Navigation/patisseries.html.twig');
    }

    public function evenementAction()
    {
        return $this->render('@Evenement/Navigation/evenement.html.twig');
    }
    public function forumAction()
    {
        return $this->render('@Evenement/Navigation/forum.html.twig');
    }
}