<?php

namespace FeteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FeteBundle:Default:index.html.twig');
    }
}
