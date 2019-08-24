<?php

namespace AnnuaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Annuaire/Default/index.html.twig');
    }


}
