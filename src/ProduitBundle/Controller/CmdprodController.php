<?php

namespace ProduitBundle\Controller;

use ProduitBundle\Entity\Cmdprod;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;

/**
 * Cmdprod controller.
 *
 */
class CmdprodController extends Controller
{
    /**
     * Lists all cmdprod entities.
     *
     */



    public function DeletecmdAction($idcp,$idpro)
    {
        $em = $this->getDoctrine()->getManager();
        $cmdpro=$em->getRepository("ProduitBundle:Cmdprod")->find($idcp);
        $emmm = $this->getDoctrine()->getManager();
        $prods = $emmm->getRepository("ProduitBundle:Prods")->find($idpro);
        $prods->setStock($prods->getStock()+1);
        $em->remove($cmdpro);

        $em->flush();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($cmdpro);
        return new JsonResponse($formatted);

    }




    public function allmAction()
    {
        $cmd=$this->getDoctrine()->getManager()->getRepository('ProduitBundle:Cmdprod')->findAll();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($cmd);
        return new JsonResponse($formatted);
    }
    public function newmAction($idpro)
    {
        $em = $this->getDoctrine()->getManager();
        $cmdprod = new Cmdprod();

        $prods=$em->getRepository( 'ProduitBundle:Prods')->find($idpro);
        $cmdprod->setIdu(2);
        $cmdprod->setIdpro($prods);
        $cmdprod->setNompro($prods->getNompro());
        $cmdprod->setPrixpro($prods->getPrixpro());
        $cmdprod->setCategoriepro($prods->getCategoriepro());
        $cmdprod->setDetailspro($prods->getDetailspro());
        $cmdprod->setNompat($prods->getNompat());
        $cmdprod->setImage($prods->getImage());
        $prods->setStock($prods->getStock() - 1);

        // $em = $this->getDoctrine()->getManager();
        $em->persist($cmdprod);
        $em->flush();

        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($cmdprod);
        return new JsonResponse($formatted);


    }
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cmdprods = $em->getRepository('ProduitBundle:Cmdprod')->findAll();

        return $this->render('@Produit/cmdprod/index.html.twig', array(
            'cmdprods' => $cmdprods,
        ));
    }

    /**
     * Creates a new cmdprod entity.
     *
     */
    public function newAction(Request $request)
    {
        $cmdprod = new Cmdprod();

        if ($request->isMethod('Post')) {
            $cmdprod->setIdu(2);
            $cmdprod->setIdpro(3);
            $cmdprod->setNompro($request->get('nompro'));
            $cmdprod->setPrixpro($request->get('prixpro'));
            $cmdprod->setCategoriepro($request->get('categoriepro'));
            $cmdprod->setDetailspro($request->get('detailspropro'));
            $cmdprod->setNompat($request->get('nompat'));
            $cmdprod->setImage($request->get('image'));
            $cmdprod->setDate(new \DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($cmdprod);
            $em->flush();

        }

        return $this->redirect($this->generateUrl('cmdprod_index'));
    }

    /**
     * Finds and displays a cmdprod entity.
     *
     */
    public function showAction(Cmdprod $cmdprod)
    {
        $deleteForm = $this->createDeleteForm($cmdprod);

        return $this->render('@Produit/cmdprod/show.html.twig', array(
            'cmdprod' => $cmdprod,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cmdprod entity.
     *
     */
    public function editAction(Request $request, Cmdprod $cmdprod)
    {
        $deleteForm = $this->createDeleteForm($cmdprod);
        $editForm = $this->createForm('ProduitBundle\Form\CmdprodType', $cmdprod);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cmdprod_edit', array('idcp' => $cmdprod->getIdcp()));
        }

        return $this->render('@Produit/cmdprod/edit.html.twig', array(
            'cmdprod' => $cmdprod,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cmdprod entity.
     *
     */
    public function deleteAction(Request $request, Cmdprod $cmdprod)
    {
        $form = $this->createDeleteForm($cmdprod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cmdprod);

            $em->flush();
        }

        return $this->redirectToRoute('cmdprod_index');
    }

    /**
     * Creates a form to delete a cmdprod entity.
     *
     * @param Cmdprod $cmdprod The cmdprod entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cmdprod $cmdprod)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cmdprod_delete', array('idcp' => $cmdprod->getIdcp())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function AjouterAuPanierAction($idpro)
    {

        $user=$this->getUser();
        $em=$this->getDoctrine()->getManager();
        $prods=$em->getRepository( 'ProduitBundle:Prods')->find($idpro);
        if($prods->getStock()<1){

            return $this->render("@Produit/cmdprod/stock.html.twig");

        }
        else {

            $cmsprod = new Cmdprod();
            $cmsprod->setIdu($user->getId());
            $cmsprod->setIdpro($prods);

            $cmsprod->setNompro($prods->getNompro());
            $cmsprod->setPrixpro($prods->getPrixpro());


            $cmsprod->setCategoriepro($prods->getCategoriepro());
            $cmsprod->setDetailspro($prods->getDetailspro());
            $cmsprod->setNompat($prods->getNompat());

            $cmsprod->setImage($prods->getImage());
            $prods->setStock($prods->getStock() - 1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($cmsprod);
            $em->flush();

            $em1 = $this->getDoctrine()->getManager();

            $prods = $em1->getRepository('ProduitBundle:Prods')->findAll();

            return $this->render('@Produit/prods/index.html.twig', array(
                'prods' => $prods,
            ));
        }

    }
    public function ListPanierAction()
    {
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $cmdprod= $em->getRepository("ProduitBundle:Cmdprod")->findBy(array("idu"=>$user));
        return $this->render("@Produit/cmdprod/ajoutauxpaniers.html.twig", array("cmdprod" => $cmdprod));
    }

    public function AffselonIdAction(Request $request){


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
    public function DeletePanierProduitAction($idcp,$idpro)
    {
        $em = $this->getDoctrine()->getManager();
        $cmdpro=$em->getRepository("ProduitBundle:Cmdprod")->find($idcp);
        $emmm = $this->getDoctrine()->getManager();
        $prods = $emmm->getRepository("ProduitBundle:Prods")->find($idpro);
        $prods->setStock($prods->getStock()+1);
        $em->remove($cmdpro);

        $em->flush();
        $user=$this->getUser();
        $emm = $this->getDoctrine()->getManager();
        $cmdpro = $emm->getRepository("ProduitBundle:Cmdprod")->findBy(array("idu"=>$user));
        return $this->render("@Produit/cmdprod/ajoutauxpaniers.html.twig", array("cmdprod" => $cmdpro));    }


}
