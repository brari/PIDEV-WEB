<?php

namespace FeteBundle\Controller;

use FeteBundle\Entity\Fete;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

/**
 * Fete controller.
 *
 */
class FeteController extends Controller
{
    /**
     * Lists all fete entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fetes = $em->getRepository('FeteBundle:Fete')->findAll();

        return $this->render('fete/index.html.twig', array(
            'fetes' => $fetes,
        ));
    }

    /**
     * Creates a new fete entity.
     *
     */
    public function newAction(Request $request)
    {
        $fete = new Fete();
        $form = $this->createForm('FeteBundle\Form\FeteType', $fete);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('UserBundle:User')->findAll();
//$prods =  $em->getRepository('AnnuaireBundle:Prods')->findAll();

        if ($form->isSubmitted() && $form->isValid()  ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fete);
            $em->flush();
           /* if($request->isMethod('POST')){
            while($request->get('produit') != ""){
                $prod = $em->getRepository('AnnuaireBundle:Prods')->find($request->get('produit'));
                $prod->setIdf($fete->getIdf());
                $em->flush();
            }*/
            return $this->redirectToRoute('crud_show', array('idf' => $fete->getIdf()));
       }

        return $this->render('fete/new.html.twig', array(
            'fete' => $fete,
            'form' => $form->createView(),'users' => $users,
        ));
    }

    /**
     * Finds and displays a fete entity.
     *
     */
    public function showAction(Fete $fete)
    {
        $deleteForm = $this->createDeleteForm($fete);

        return $this->render('fete/show.html.twig', array(
            'fete' => $fete,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fete entity.
     *
     */
    public function editAction(Request $request, Fete $fete)
    {
        $deleteForm = $this->createDeleteForm($fete);
        $editForm = $this->createForm('FeteBundle\Form\FeteType', $fete);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('crud_edit', array('idf' => $fete->getIdf()));
        }

        return $this->render('fete/edit.html.twig', array(
            'fete' => $fete,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fete entity.
     *
     */
    public function deleteAction(Request $request, Fete $fete)
    {
        $form = $this->createDeleteForm($fete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fete);
            $em->flush();
        }

        return $this->redirectToRoute('crud_index');
    }

    /**
     * Creates a form to delete a fete entity.
     *
     * @param Fete $fete The fete entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fete $fete)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('crud_delete', array('idf' => $fete->getIdf())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
