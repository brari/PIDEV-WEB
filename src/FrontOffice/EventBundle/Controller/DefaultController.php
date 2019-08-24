<?php

namespace FrontOffice\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontOfficeEventBundle:Default:index.html.twig');
    }
}
