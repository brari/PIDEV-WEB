<?php

namespace PatisserieBundle\Controller;

use AnnuaireBundle\Entity\Patisserie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PatisserieController extends Controller
{
    public function afficherAction(){
        $patisserie=$this->getDoctrine()->getRepository(Patisserie::class)->findAll();
        return $this->render('@Patisserie/affiche.html.twig',array('patisseries'=>$patisserie));
    }
}
