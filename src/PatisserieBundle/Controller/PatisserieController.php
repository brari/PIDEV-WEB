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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            $em = $this->getDoctrine()->getManager();
            //relation one to many
            $user=$em->getRepository('UserBundle:User')->find($id);
            $patisserie->setIdprop($user);
            //
            if($patisserie->getUrl()!==null) {
                //initialize the uploader
                $uploader = new FileUploader('Images');
                // $file stores the uploaded file
                $file = $patisserie->getUrl();
                $fileName = $uploader->upload($file);
                // updates the 'photo' property to store the PDF file name instead of its contents
                $patisserie->setUrl($fileName);
            }
            $patisserie->setRating(0);
            $nb=$request->get('pdispo');
            $patisserie->setPlace($nb);


<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
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

        $map=new Map();
        $map->setAutoZoom(false);
        $map->setCenter(new Coordinate(36.911964,10.185363));
        $map->setMapOption('zoom',10);
        $map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
        $marker = new Marker(
            new Coordinate(36.911964,10.185363),
            Animation::BOUNCE,
            new Icon(),
            new Symbol(SymbolPath::CIRCLE),
            new MarkerShape(MarkerShapeType::CIRCLE, [1.1, 2.1, 1.4]),
            ['clickable' => false]
        );
        $map->getOverlayManager()->addMarker($marker);
        $map->setMapOption('width',500); $map->setMapOption('heigth',500);
<<<<<<< Updated upstream
        $map->setMapOption('mapTypeId', MapTypeId::HYBRID);
=======
        //$map->setMapOption('mapTypeId', MapTypeId::HYBRID);
>>>>>>> Stashed changes

        return $this->render('@Patisserie/Patissier/detail.html.twig',array('patisserie'=>$patisserie,'map'=>$map));
    }

    public function detailclientAction(Request $request){
        $id=$request->get('id');
        $patisserie=$this->getDoctrine()->getRepository(Patisserie::class)->find($id);
        return $this->render('@Patisserie/Client/detail.html.twig',array('patisserie'=>$patisserie,));
    }

    public function modifierAction(Request $request)
    {
        $id=$request->get('id');
        $patisserie= $this->getDoctrine()->getRepository(Patisserie::class)->find($id);
        //recupere le nom de l'ancien fichier enregistré dans la base
        $photo=$patisserie->getUrl();
        //on met lurl a nul pour permettre l'affichage du filetype
        //le file type prend en parametre un file donc avec un string il fait des erreurs
        $patisserie->setUrl(null);
        $deleteForm = $this->createDeleteForm($patisserie);
        $form= $this->createForm(PatisserieType::class,$patisserie);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            //on vérifie si le nouveau nom de photo est toujours null, si oui on remet l'ancienne photo
            if($patisserie->getUrl()== null){
                $patisserie->setUrl($photo);
            }
            else{
                //s'il ,n'est pas nul c'est que la personne a choisi une nouvelle photo donc on reload
                //on garde le meme nom de photo mais le contenu change
                $uploader = new FileUploader('C:\wamp64\www\AnnuaireWeb\web\Images');
                $file = $patisserie->getUrl();
                $fileName = $uploader->upload($file);
                $patisserie->setUrl($fileName);
            }
            $patisserie->setPlace($request->get('pdispo'));
            $em= $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("patisserie_detail",array('id' => $patisserie->getIdp()));
        }
        return $this->render("@Patisserie/Patissier/modifier.html.twig",
            array("form_modifier"=>$form->createView(),"patisserie"=>$patisserie,'delete_form' => $deleteForm->createView()));
    }

    /**
     * Creates a form to delete a patisserie entity.
     *
     * @param Patisserie $patisserie The patisserie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Patisserie $patisserie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('patisserie_supprimer', array('id' => $patisserie->getIdp())))
            ->setMethod('DELETE')
            ->add('Supprimer', SubmitType::class, array('attr' => array('onclick' =>
                'return confirm("Voulez vous vraiment supprimer la patisserie?")'
                )))

            ->getForm()
            ;
    }

    public function supprimerAction(Request $request)
    {
        $id=$request->get('id');
        $patisserie= $this->getDoctrine()->getManager()->getRepository('PatisserieBundle:Patisserie')->find($id);
        $deleteForm = $this->createDeleteForm($patisserie);
        $deleteForm->handleRequest($request);
        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($patisserie);
            $em->flush();
        }
        return $this->redirectToRoute('patisserie_homepage');
    }

    public function listeAction(Request $request){
        $patisserie = $this->getDoctrine()->getRepository(Patisserie::class)->findAllOrderedByName();
        return $this->render('@Patisserie/Patissier/liste.html.twig', array('patisseries' => $patisserie));
    }
}
