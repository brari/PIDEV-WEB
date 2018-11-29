<?php

namespace PatisserieBundle\Controller;

use AnnuaireBundle\Service\FileUploader;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;
use PatisserieBundle\Entity\Patisserie;
use PatisserieBundle\Form\PatisserieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class PatisserieController extends Controller
{
    public function afficherAction(Request $request){
        $id=$this->getUser()->getid();
        if($request->query->get('nomp')!=null){
            $em=$this->getDoctrine()->getManager();
            $patisseries=$em->getRepository("PatisserieBundle:Patisserie")->findMaPatisserie($request->query->get('nomp'),$id);
            return $this->render('@Patisserie/Patissier/affiche.html.twig',array('patisseries'=>$patisseries));
        }
        else {
            $patisserie = $this->getDoctrine()->getRepository(Patisserie::class)->mesPatisseries($id)
             ;
            return $this->render('@Patisserie/Patissier/affiche.html.twig', array('patisseries' => $patisserie));
        }
    }

    public function afficherclientAction(Request $request){
        if($request->query->get('nomp')!=null){
            $em=$this->getDoctrine()->getManager();
            $patisseries=$em->getRepository("PatisserieBundle:Patisserie")->findPatisserie($request->query->get('nomp'));
            return $this->render('@Patisserie/Client/affiche.html.twig',array('patisseries'=>$patisseries));
        }
        else {
            $patisserie = $this->getDoctrine()->getRepository(Patisserie::class)->findAll();
            return $this->render('@Patisserie/Client/affiche.html.twig', array('patisseries' => $patisserie));
        }
    }

    public function ajouterAction(Request $request)
    {
        $patisserie = new Patisserie();
        $form = $this->createForm(PatisserieType::class, $patisserie);
        $form->handleRequest($request);
        $id=$this->getUser()->getid();

        if ($form->isSubmitted() && $form->isValid()) {
            if($request->hasSession()){
                $patisserie->setIdprop($id);
            }
            if($patisserie->getUrl()!==null) {
                //initialize the uploader
                $uploader = new FileUploader('C:\wamp64\www\AnnuaireWeb\web\Images');
                // $file stores the uploaded file
                $file = $patisserie->getUrl();
                $fileName = $uploader->upload($file);
                // updates the 'photo' property to store the PDF file name instead of its contents
                $patisserie->setUrl($fileName);
            }
            $patisserie->setRating(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($patisserie);
            $em->flush();

            return $this->redirectToRoute('patisserie_detail',array('id'=>$patisserie->getIdp()));
        }

        return $this->render('@Patisserie/Patissier/ajouter.html.twig', array(
            'patisseries' => $patisserie,
            'form' => $form->createView(),
        ));
    }

    public function detailAction(Request $request){
        $id=$request->get('id');
        $patisserie=$this->getDoctrine()->getRepository(Patisserie::class)->find($id);
        return $this->render('@Patisserie/Patissier/detail.html.twig',array('patisserie'=>$patisserie));
    }

    public function modifierAction(Request $request,$id)
    {
        $patisserie= $this->getDoctrine()->getRepository(Patisserie::class)->find($id);
        $form= $this->createForm(PatisserieType::class,$patisserie);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em= $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("patisserie_detail");
        }
        return $this->render("@Patisserie/Patissier/modifier.html.twig",
            array("form_modifier"=>$form->createView(),"patisserie"=>$patisserie));
    }
}
