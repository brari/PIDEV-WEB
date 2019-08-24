<?php

namespace FrontOffice\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontOfficeForumBundle:Default:index.html.twig');
    }
}
