<?php

namespace recetteBundle\Controller;

use AnnuaireBundle\Entity\ordertab;
use AnnuaireBundle\Entity\Patisserie;
use AnnuaireBundle\Entity\Recette;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Recette controller.
 *
 */
class RecetteClientController extends Controller
{
    /**
     * Lists all recette entities.
     *
     */

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recettes = $em->getRepository('AnnuaireBundle:Recette')->findAll();

        return $this->render('recetteclient/index.html.twig', array(
            'recettes' => $recettes,
        ));
    }

    /**
     * Creates a new recette entity.
     *
     */
    public function newAction(Request $request)
    {
        $recette = new Recette();
        $form = $this->createForm('AnnuaireBundle\Form\RecetteType', $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recette);
            $em->flush();

            return $this->redirectToRoute('recetteclient_show', array('id' => $recette->getId()));
        }

        return $this->render('recetteclient/new.html.twig', array(
            'recette' => $recette,
            'form' => $form->createView(),
        ));
    }
    public function addOrderAction()
    {
        $order = new ordertab();




            $em = $this->getDoctrine()->getManager();
            $order->setIdRecette(1);
            $order->setIdu(1);
            $order->setPrice(20);
            $order->setRecetteName("badr");
            $em->persist($order);
            $em->flush();

            return $this->redirectToRoute('recetteclient_index');


    }
    public function payAction()
    {

        $em = $this->getDoctrine()->getManager();

        $orders = $em->getRepository('AnnuaireBundle:ordertab')->findAll();

        return $this->render('recetteclient/checkout.html.twig', array(
            'orders' => $orders,
        ));
       // return $this->render('recette/checkout.html.twig');

    }

    public function paylastAction()
    {


         return $this->render('recetteclient/paylast.html.twig');

    }
    /**
     * Finds and displays a recette entity.
     *
     */
    public function showAction(Recette $recette)
    {
        $deleteForm = $this->createDeleteForm($recette);

        return $this->render('recetteclient/show.html.twig', array(
            'recette' => $recette,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing recette entity.
     *
     */
    public function editAction(Request $request, Recette $recette)
    {
        $deleteForm = $this->createDeleteForm($recette);
        $editForm = $this->createForm('AnnuaireBundle\Form\RecetteType', $recette);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recetteclient_edit', array('id' => $recette->getId()));
        }

        return $this->render('recetteclient/edit.html.twig', array(
            'recette' => $recette,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a recette entity.
     *
     */
    public function deleteAction(Request $request, Recette $recette)
    {
        $form = $this->createDeleteForm($recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recette);
            $em->flush();
        }

        return $this->redirectToRoute('recetteclient_index');
    }

    /**
     * Creates a form to delete a recette entity.
     *
     * @param Recette $recette The recette entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Recette $recette)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recette_delete', array('id' => $recette->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function panierAction(Request $request){
       return  $request;
    }
    public function commandeAction()
    {
        return $this->render('@Patisserie/commande.html.twig');

    }

}


