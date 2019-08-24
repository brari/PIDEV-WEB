<?php

namespace EvenementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\ResponseRedirect  ;
use EvenementBundle\Entity\Evenements;
use EvenementBundle\Entity\User;
use EvenementBundle\Form\EvenementsType;
use EvenementBundle\Form\AfficheType;
use EvenementBundle\Entity\Participants;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Evenement/Default/index.html.twig');
    }

    public function allAction()
    {
        $evenement = $this->getDoctrine()->getManager()->getRepository('EvenementBundle:Evenements')->findAll();
        $serializer = new serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($evenement);
        return new JsonResponse($formatted);

    }

    public function newAction(request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = new Evenements();
        // user_id=1;
        $evenement->setUserid($request->get('user_id'));
        $evenement->setNomE($request->get('nomE'));
        $evenement->setDescriptionE($request->get('descriptionE'));
        $evenement->setAdresseE($request->get('adresseE'));
        $evenement->setTypeE($request->get('typeE'));

        //$evenement->setDateE($request->get('dateE'));
        $evenement->setImageE($request->get('imageE'));
        $evenement->setInteresses($request->get('interesses'));
        $evenement->setCapacite($request->get('capacite'));
        $em->persist($evenement);
        $em->flush();
        $serializer = new serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($evenement);
        return new JsonResponse($formatted);

    }

    public function deleteAction($ide)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('EvenementBundle:Evenements')->find($ide);
        $em->remove($evenement);
        $em->flush();
        $serializer = new serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($evenement);
        return new JsonResponse($formatted);

    }

    public function partiAction($ide)
    {
        $em = $this->getDoctrine()->getManager();
        $participation=new Participants();

        $evenement=$em->getRepository('EvenementBundle:Evenements')->findOneBy(["ide"=>$ide]);
        $evenement->setInteresses($evenement->getInteresses()+1);
        $participation->setEven($evenement);
        $em->persist($participation);
        $em->flush();
        $em->persist($evenement);
        $em->flush();
        $serializer = new serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($evenement);
        return new JsonResponse($formatted);

    }


    public function annulerAction($ide)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository('EvenementBundle:Evenements')->findOneBy(["ide"=>$ide]);
        $participation=$em->getRepository('EvenementBundle:Participants')->findOneBy(["even"=>$ide]);
        $evenement->setInteresses($evenement->getInteresses()-1);
        $em->remove($participation);
        $em->persist($participation);
        $em->flush();

        $em->persist($evenement);
        $em->flush();
        $serializer = new serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($evenement);
        return new JsonResponse($formatted);

    }

    public function modifAction(request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement=$em->getRepository("EvenementBundle:Evenements")->find($request->get('ide'));
        //$evenement = new Evenements();
        // user_id=1;
        //$evenement->setUserid($request->get('user_id'));
        $evenement->setNomE($request->get('nomE'));
        $evenement->setDescriptionE($request->get('descriptionE'));
        $evenement->setAdresseE($request->get('adresseE'));
        $evenement->setTypeE($request->get('typeE'));

        //$evenement->setDateE($request->get('dateE'));
        $evenement->setImageE($request->get('imageE'));
        $evenement->setInteresses($request->get('interesses'));
        $evenement->setCapacite($request->get('capacite'));
        $em->persist($evenement);
        $em->flush();
        $serializer = new serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($evenement);
        return new JsonResponse($formatted);

    }

    public function evenAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('EvenementBundle:Evenements')->findAll();
        $pg=$this->get('knp_paginator');
        $pagination=$pg->paginate($evenements,
            $request->query->get('page',1),2

        );
        return $this->render('@Evenement/Patissier/afficherEvenement.html.twig' ,array(
            'evenements' => $pagination,
    ));
    }

    public function evencltAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('EvenementBundle:Evenements')->findAll();
        $pg=$this->get('knp_paginator');
        $pagination=$pg->paginate($evenements,
            $request->query->get('page',1),2

        );
        return $this->render('@Evenement/Client/afficher.html.twig' ,array(
            'evenements' => $pagination,
        ));
    }


    public function afficheclientAction(Request $request)
    {

        $evenements=$this->getDoctrine()->getRepository(Evenements::class)->findAll();
        //add the list of modeles to the render function as input to be sent to the view
        return $this->render('@Evenement/Client/Afficher.html.twig', array(
            'evenements'=>$evenements
        ));
    }


    public function clientAction(Request $request)
    {

        $evenements=$this->getDoctrine()->getRepository(Evenements::class)->findAll();
        //add the list of modeles to the render function as input to be sent to the view
        return $this->render('@Evenement/Client/index.html.twig', array(
            'evenements'=>$evenements
        ));
    }


    public function afficherevennomAction(Request $request){
        if($request->query->get('nomE')!=null)
        {
            $em=$this->getDoctrine()->getManager();
            $evenement=$em->getRepository("EvenementBundle:Evenements")->findEvenement($request->query->get('nomE'));
            return $this->render('@Evenement/Client/cherche.html.twig',array('evenements'=>$evenement));
        }
        else {
            $evenement = $this->getDoctrine()->getRepository(Evenements::class)->findAll();
            return $this->render('@Evenement/Client/cherche.html.twig', array('evenements'=>$evenement));
        }
    }

    public function afficherpatAction(Request $request){
        if($request->query->get('nomE')!=null)
        {
            $em=$this->getDoctrine()->getManager();
            $evenement=$em->getRepository("EvenementBundle:Evenements")->findEvenement($request->query->get('nomE'));
            return $this->render('@Evenement/Patissier/recherche.html.twig',array('evenements'=>$evenement));
        }
        else {
            $evenement = $this->getDoctrine()->getRepository(Evenements::class)->findAll();
            return $this->render('@Evenement/Patissier/recherche.html.twig', array('evenements'=>$evenement));
        }
    }

    public function affichercltAction(Request $request){
        if($request->query->get('nomE')!=null)
        {
            $em=$this->getDoctrine()->getManager();
            $evenement=$em->getRepository("EvenementBundle:Evenements")->findEvenement($request->query->get('nomE'));
            return $this->render('@Evenement/Client/recherche.html.twig',array('evenements'=>$evenement));
        }
        else {
            $evenement = $this->getDoctrine()->getRepository(Evenements::class)->findAll();
            return $this->render('@Evenement/Client/recherche.html.twig', array('evenements'=>$evenement));
        }
    }



    public function ajouterAction(Request $request)
    {   $msg=0;
        $evenement = new Evenements();
        $form = $this->createForm('EvenementBundle\Form\EvenementsType', $evenement);
        $form->handleRequest($request);
        $time = new \DateTime();
        $time->format('Y-m-d');

        if ($form->isSubmitted() && $form->isValid()&& $evenement->getDateE()>$time)
        {
            $em = $this->getDoctrine()->getManager();
            $evenement->setUser_id($this->getUser());
            $em->persist($evenement);
            $em->flush();
            $msg=1;
        }

        else if ($form->isSubmitted() && !$form->isValid())
        {
            $msg=2;
        }
        else if ($form->isSubmitted() && $evenement->getDateE()<$time)
        {
            $msg=2;
        }
        return $this->render('@Evenement/Patissier/ajouterEvenement.html.twig', array(
            'evenements' => $evenement,
            'form' => $form->createView(),
            'message'=>$msg,
        ));
    }

    public function supprimerAction($idE)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $evenement=$em->getRepository("EvenementBundle:Evenements")->find($idE);
        //remove from the ORM
        $em->remove($evenement);
        //update the data base
        $em->flush();
        return $this->redirectToRoute('even_evenement');
    }

    public function modifierAction(Request $request,$idE)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement=$em->getRepository("EvenementBundle:Evenements")->find($idE);
        $Form=$this->createForm(EvenementsType::class,$evenement);
        $Form->handleRequest($request);
        if($Form->isSubmitted()) {
            $evenement->setImageE($evenement->getImageE());
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('even_evenement');
        }
        return $this->render("@Evenement/Patissier/modifierEvenement.html.twig",array('form'=>$Form->createView()));
    }

    public function trierAction(Request $request)
    {
        $evenement= new Evenements();
        $form= $this->createForm(AfficheType::class,$evenement);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $evenements= $this->getDoctrine()->getRepository(Evenements::class)
                ->findBy(array('typeE'=>$evenement->getTypeE()));

        }
        else{
            $evenements= $this->getDoctrine()->getRepository(Evenements::class)
                ->findAll();
        }
        return $this->render("@Evenement/Patissier/trie.html.twig",array("form"=>$form->createView(),'evenements'=>$evenements));

    }

    public function triercltAction(Request $request)
    {
        $evenement= new Evenements();
        $form= $this->createForm(AfficheType::class,$evenement);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $evenements= $this->getDoctrine()->getRepository(Evenements::class)
                ->findBy(array('typeE'=>$evenement->getTypeE()));

        }
        else{
            $evenements= $this->getDoctrine()->getRepository(Evenements::class)
                ->findAll();
        }
        return $this->render("@Evenement/Client/tier.html.twig",array("form"=>$form->createView(),'evenements'=>$evenements));

    }

    public function incrementAction(Request $request,$idE)
    {   $participation=new Participants();
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository('EvenementBundle:Evenements')->findOneBy(["ide"=>$idE]);
        $evenement->setInteresses($evenement->getInteresses()+1);

        $participation->setEven($evenement);
        $em->persist($participation);
        $em->flush();

        $em->persist($evenement);
        $em->flush();


        return $this->redirectToRoute('affiche_even_clt');

    }

    public function decrementAction(Request $request,$idE)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository('EvenementBundle:Evenements')->findOneBy(["ide"=>$idE]);
        $participation=$em->getRepository('EvenementBundle:Participants')->findOneBy(["even"=>$idE]);
        $evenement->setInteresses($evenement->getInteresses()-1);
        $em->remove($participation);
        $em->persist($participation);
        $em->flush();

        $em->persist($evenement);
        $em->flush();
        return $this->redirectToRoute('affiche_even_clt');
    }


    public function afficheparticipationAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $participations = $em->getRepository('EvenementBundle:Evenements')->findAll();
        $pg=$this->get('knp_paginator');
        $pagination=$pg->paginate($participations,
            $request->query->get('page',1),2

        );
        return $this->render('@Evenement/Patissier/afficheparticipation.html.twig' ,array(
            'evenements' => $pagination,
        ));
    }



    public function affichermesevenementsAction(Request $request)
    {
        $id=$this->getUser()->getid();
        $evenement = $this->getDoctrine()->getRepository(Evenements::class)->mesEvenements($id);
        return $this->render('@Evenement/Patissier/affichemeseven.html.twig', array('evenements' => $evenement));

    }

    public function retourcltAction()
    {
        return $this->render('@Evenement/Client/index.html.twig');
    }

    public function retourpatAction()
    {
        return $this->render('@Evenement/Patissier/afficherEvenement.html.twig');
    }





}
