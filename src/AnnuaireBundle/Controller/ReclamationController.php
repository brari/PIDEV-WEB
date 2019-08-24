<?php

namespace EspritApiBundle\Controller;

use ReclamationBundle\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ReclamationController extends Controller
{
    public function allAction(){
        $Reclamation = $this->getDoctrine()->getManager()->getRepository('ReclamationBundle:Reclamation')->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Reclamation);
        return new JsonResponse($formatted);
    }
    public function findAction($id){
        $Reclamation = $this->getDoctrine()->getManager()->getRepository('ReclamationBundle:Reclamation')->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Reclamation);
        return new JsonResponse($formatted);
    }
    public function newAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $Reclamation = new Reclamation();
        $Reclamation->setType($request->get('type'));
        $Reclamation->setContenu($request->get('contenu'));
        $Reclamation->setObjet($request->get('objet'));
        $Reclamation->setStatut("en cours");
        $Reclamation->setDate($request->get('date'));
        $Reclamation->setIdReclamant($request->get('id_reclamant'));
        //$Reclamation->setIdConcerne ($request->get('id_concerne'));
        $Reclamation->setnomConcerne($request->get('id_concerne'));
        $em->persist($Reclamation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Reclamation);
        return new JsonResponse($formatted);
    }
    public function editAction($id,Request $request)
    {
        $Reclamation = $this->getDoctrine()->getManager()->getRepository('ReclamationBundle:Reclamation')->updatetask($id,$request);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Reclamation);
        return new JsonResponse($formatted);
    }
}
