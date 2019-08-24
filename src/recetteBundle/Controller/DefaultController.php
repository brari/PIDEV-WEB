<?php

namespace recetteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\ResponseRedirect  ;
use AnnuaireBundle\Entity\Recette;
use EvenementBundle\Entity\User;
use EvenementBundle\Form\EvenementsType;
use EvenementBundle\Form\AfficheType;
use EvenementBundle\Entity\Participants;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('recetteBundle:Default:index.html.twig');
    }


    public function allRecetteAction()
    {
        $recette = $this->getDoctrine()->getManager()->getRepository('AnnuaireBundle:Recette')->findAll();
        $serializer = new serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($recette);
        return new JsonResponse($formatted);

    }


    public function AffiallRecetteAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager(); //pour la récupération et la manipulation des données
        $Recette = $em->getRepository("AnnuaireBundle:Recette")->findAll();
        $seializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $seializer->normalize($Recette);
        return new JsonResponse($formatted);


    }


}
