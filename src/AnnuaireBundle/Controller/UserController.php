<?php

namespace AnnuaireBundle\Controller;

use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UserController extends Controller
{
    public function allAction(){
        $user = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function findAction($username){
        $user = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->findBy(array('username'=>$username));
        //$user = $this->getDoctrine()->getManager()->getRepository('EspritApiBundle:User')->findByUsername($username);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
    public function newAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setPassword($request->get('password'));
        $user->setRoles($request->get('roles'));
        $user->setTelephone($request->get('telephone'));
        $user->setAdresse($request->get('adresse'));
        $user->setNom($request->get('nom'));
        $user->setPrenom($request->get('prenom'));
        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);

    }
    public function editAction($id,Request $request)
    {
        $user = $this->getDoctrine()->getManager()->getRepository('UserBundle:User')->updateuser($id,$request);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

}
