<?php

namespace AnnuaireBundle\Controller;

use PatisserieBundle\Entity\Patisserie;
use PatisserieBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;

class APIController extends Controller
{
    public function allAction()
    {
        $patisseries=$this->getDoctrine()->getManager()->getRepository(Patisserie::class)->findAll();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($patisseries);
        return new JsonResponse($formatted);
    }

    public function findAction($id)
    {
        $patisserie=$this->getDoctrine()->getManager()->getRepository(Patisserie::class)->find($id);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($patisserie);
        return new JsonResponse($formatted);
    }

    public function findPatAction($id)
    {
        $patisserie=$this->getDoctrine()->getManager()->getRepository(Patisserie::class)->mesPatisseries($id);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($patisserie);
        return new JsonResponse($formatted);
    }


    public function newAction(Request $request)
    {
        $id=$request->get('id');
        $patisserie= $this->getDoctrine()->getRepository(Patisserie::class)->find($id);

        $em=$this->getDoctrine()->getManager();

        $patisserie->setNom($request->get('nom'));
        $patisserie->setAdresse($request->get('adresse'));
        $patisserie->setContact($request->get('contact'));
        $patisserie->setMail($request->get('mail'));
        if($request->get('places')==null)
            $patisserie->setPlace(0);
        else
            $patisserie->setPlace($request->get('places'));
        $patisserie->setReservation($request->get('reservation'));
        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($patisserie);
        return new JsonResponse($formatted);
    }

    public function removePatAction($id){
        $em=$this->getDoctrine()->getManager();
        $patisserie=$em->getRepository(Patisserie::class)->find($id);
        $em->remove($patisserie);
        $em->flush();

        $patisseries=$this->getDoctrine()->getManager()->getRepository(Patisserie::class)->findAll();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($patisseries);
        return new JsonResponse($formatted);
    }


    public function allUserAction()
    {
        $users=$this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($users);
        return new JsonResponse($formatted);
    }

    public function findUserAction($id)
    {
        $user=$this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($user);
        return new JsonResponse($formatted);
    }


    public function newResAction(Request $request)
    {
        $reservation= new Reservation();
        $em=$this->getDoctrine()->getManager();

        $reservation->setDate($request->get('date'));
        $reservation->setHeure($request->get('heure'));
        $reservation->setPlaces($request->get('places'));
        $patisserie=$em->getRepository(Patisserie::class)->find($request->get('idpat'));
        $user=$em->getRepository(User::class)->find($request->get('iduser'));
        $reservation->setIduser($user);
        $reservation->setIdpat($patisserie);
        $em->persist($reservation);
        $em->flush();

        /*$serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($reservation);
        return new JsonResponse($formatted);*/
    }


    public function allReservationAction()
    {
        $reservations=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->findAll();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($reservations);
        return new JsonResponse($formatted);
    }

    public function findUserResAction($id)
    {
        $reservations=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->findMyReservations($id);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($reservations);
        return new JsonResponse($formatted);
    }

    public function findPatResAction($id)
    {
        $reservations=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->mesReservations($id);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($reservations);
        return new JsonResponse($formatted);
    }

    public  function nombreAction($id){
        $nb=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->nbReservations($id);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($nb);
        return new JsonResponse($formatted);
    }
}
