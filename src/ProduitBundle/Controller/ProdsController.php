<?php

namespace ProduitBundle\Controller;

use ProduitBundle\Entity\Prods;
use ProduitBundle\Form\ProdsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;

/**
 * Prods controller.
 *
 */
class ProdsController extends Controller
{
    /**
     * Lists all prods entities.
     *
     */
    public function updateAction($idpro,$nompro,$prixpro,$categoriepro,$detailspro,$nompat,$stock) {


        $em=$this->getDoctrine()->getManager();
        $req="update prods s set s.nompro= :nompro ,s.prixpro=:prixpro , s.categoriepro=:categoriepro,s.detailspro=:detailspro ,s.nompat=:nompat ,s.stock=:stock WHERE s.idpro=:idpro ;" ;
        $statement = $em->getConnection()->prepare($req);
        $statement->bindValue('idpro', $idpro);
        $statement->bindValue('nompro', $nompro);
        $statement->bindValue('prixpro', $prixpro);
        $statement->bindValue('categoriepro', $categoriepro);
        $statement->bindValue('detailspro', $detailspro);
        $statement->bindValue('nompat', $nompat);
        $statement->bindValue('stock', $stock);

        $statement->execute();
        $prods=$this->getDoctrine()->getManager()->getRepository('ProduitBundle:Prods')->find($idpro);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($prods);
        return new JsonResponse($formatted);
    }

    public function findAction($id)
    {
        $prods=$this->getDoctrine()->getManager()->getRepository('ProduitBundle:Prods')->find($id);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($prods);
        return new JsonResponse($formatted);
    }
    public function findsAction($categorie)
    {
        $n=0;
        $prods=$this->getDoctrine()->getManager()->getRepository('ProduitBundle:Prods')->findBy(array("categoriepro" =>$categorie));
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($prods);
        return new JsonResponse($formatted);
    }
    public function findEtatFAction($etat){
        $n=0;
        $em = $this->getDoctrine()->getManager();
        $equipements = $em->getRepository('ProduitBundle:Prods')->findBy(array("categoriepro" => $etat));
        foreach ($equipements as $a)
        {
            $n++;
        }
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($n);
        return new JsonResponse($formatted);
    }

    public function ModifierAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();


        $idpro= $request->get('idpro');
        $prods=$em->getRepository("ProduitBundle:Prods")->find($idpro);
        //  return $this->render('@Ons/covoiturage/updateCovoiturage.html.twig',array("covoiturage"=>$covoiturage));



        $idpro= $request->get('idpro');
        $prods=$em->getRepository("ProduitBundle:Prods")->find($idpro);
        $prods->setNompro($request->get('nompro'));
        $prods->setPrixpro($request->get('prixpro'));
        $prods->setCategoriepro($request->get('categoriepro'));
        $prods->setDetailspro($request->get('detailspro'));
        $prods->setNompat($request->get('nompat'));
        $prods->setStock($request->get('stock'));
        $em->flush();

        $serializer =new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($prods);
        return new JsonResponse($formatted);

        //return $this->redirectToRoute('covoiturage_moncov');
    }
    public function allmAction()
    {
        $prods=$this->getDoctrine()->getManager()->getRepository('ProduitBundle:Prods')->findAll();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($prods);
        return new JsonResponse($formatted);
    }

    public function newmAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $prods = new Prods();

        $prods->setNompro($request->get('nompro'));
        $prods->setPrixpro($request->get('prixpro'));
        $prods->setCategoriepro($request->get('categoriepro'));
        $prods->setDetailspro($request->get('detailspro'));
        $prods->setNompat($request->get('nompat'));
        $prods->setImage($request->get('image'));
        $prods->setStock($request->get('stock'));
        $em->persist($prods);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($prods);
        return new JsonResponse($formatted);
    }

    public function deletemAction($idpro)
    {
        // $prods = new Prods();
        $em=$this->getDoctrine()->getManager();
        $prods= $em->getRepository('ProduitBundle:Prods')->find($idpro);
        $em->remove($prods);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($prods);
        return new JsonResponse($formatted);
    }




    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $prods = $em->getRepository('ProduitBundle:Prods')->findAll();

        return $this->render('@Produit/prods/index.html.twig', array(
            'prods' => $prods,
        ));
    }

    /**
     * Creates a new prods entity.
     *
     */
    public function newAction(Request $request ,$idp)
    {
        $em=$this->getDoctrine()->getManager();
        $patisserie=$em->getRepository( 'PatisserieBundle:Patisserie')->find($idp);

        $prods = new Prods();


        $form = $this->createFormBuilder($prods)
        ->add('nompro')
        ->add('prixpro')
        ->add('categoriepro')
        ->add('detailspro')
        ->add('nompat')
        ->add('image', FileType::class, array('data_class' => null,'label' => 'insérer une image','attr'=>array('style'=>'color:violet','class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))

            ->add('stock')
        ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $prods->getIdpat();
            $file = $prods->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('image_directory'), $fileName);
            $prods->setImage($fileName);
            $prods->setIdpat($patisserie);
            $em = $this->getDoctrine()->getManager();
            $em->persist($prods);
            $em->flush();

            return $this->redirectToRoute('prods_show', array('idpro' => $prods->getIdpro()));
        }

        return $this->render('@Produit/prods/new.html.twig', array(
            'prods' => $prods,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a prods entity.
     *
     */
    public function showAction(Prods $prods)
    {
        $deleteForm = $this->createDeleteForm($prods);

        return $this->render('@Produit/prods/show.html.twig', array(
            'prods' => $prods,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing prods entity.
     *
     */
    public function editAction(Request $request, $idpro)
    {

        $em = $this->getDoctrine()->getManager();
        $prods=$em->getRepository("ProduitBundle:Prods")->find($idpro);
        $Form=$this->createForm(ProdsType::class,$prods);
        $Form->handleRequest($request);
        if($Form->isSubmitted()) {
            $prods->setImage($prods->getImage());
            $em = $this->getDoctrine()->getManager();
            $em->persist($prods);
            $em->flush();
            return $this->redirectToRoute('prods_show', array('idpro' => $prods->getIdpro()));
        }

        return $this->render("@Produit/prods/edit.html.twig",array('form'=>$Form->createView()));

    }

    /**
     * Deletes a prods entity.
     *
     */
    public function deleteAction(Request $request, Prods $prods)
    {
        $form = $this->createDeleteForm($prods);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($prods);
            $em->flush();
        }

        return $this->redirectToRoute('prods_index');
    }

    /**
     * Creates a form to delete a prods entity.
     *
     * @param Prods $prods The prods entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Prods $prods)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prods_delete', array('idpro' => $prods->getIdpro())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function RechercheAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        if($request->isMethod("POST")){
            $categoriepro=$request->get('name');
            $prods = $em->getRepository("ProduitBundle:Prods")->findBy(array("categoriepro"=>$categoriepro));

        }
        return($this->render('@Produit/prods/rechercheProduit.html.twig', array(
            "prods" => $prods)));
    }

    public function afficheAction($idp)
    {



        $em = $this->getDoctrine()->getManager();
        $patisserie=$em->getRepository( 'PatisserieBundle:Patisserie')->find($idp);
        $prods = $em->getRepository('ProduitBundle:Prods')->findBy(array("idpat"=>$patisserie));
        return $this->render('@Produit/prods/affiche.html.twig', array("prods" => $prods));


    }
    public function SuggestionAction( $detailspro)
    {

        $em=$this->getDoctrine()->getManager();
         $prods = $em->getRepository("ProduitBundle:Prods")->findBy(array("detailspro"=>$detailspro));
         return($this->render('@Produit/prods/suggestion.html.twig', array("prods" => $prods)));
    }
    public function suggAction()
    {
        return $this->render('@Produit/prods/suggest.html.twig');
    }
    public function FiltrageAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        if($request->isMethod("POST")){
            $prixpro=$request->get('name');
            if ('name'=='coissant')
            $prods = $em->getRepository("ProduitBundle:Prods")->findBy(array("prixpro"=>$prixpro));

        }
        return($this->render('@Produit/prods/rechercheProduit.html.twig', array(
            "prods" => $prods)));
    }

    public function trierAction(Request $request){


        $em=$this->getDoctrine()->getManager();
        if($request->getMethod()=="POST") {

            $x = $request->get('select');

            // var_dump($x);
            if ($x == 'decroissant') {
                $query2 = $em->createQueryBuilder()->select('m')->from('ProduitBundle:Prods', 'm')

                    ->orderBy('m.prixpro', 'DESC')
                    ->getQuery();
                $prods = $query2->getResult();
            }
            if ($x == 'croissant') {
                $query2 = $em->createQueryBuilder()->select('m')->from('ProduitBundle:Prods', 'm')

                    ->orderBy('m.prixpro', 'ASC')
                    ->getQuery();
                $prods = $query2->getResult();

            }

        }
        return $this->render('@Produit/prods/trie.html.twig',array('m'=>$prods));
}

}

