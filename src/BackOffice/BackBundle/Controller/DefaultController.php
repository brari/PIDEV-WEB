<?php

namespace BackOffice\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BackOfficeBackBundle:Default:index.html.twig');
    }
}
