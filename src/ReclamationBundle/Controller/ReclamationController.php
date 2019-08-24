<?php

namespace ReclamationBundle\Controller;

use ReclamationBundle\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

/**
 * Reclamation controller.
 *
 */
class ReclamationController extends Controller
{
    /**
     * Lists all reclamation entities.
     *
     */
    public function bloquerAction(Request $request, Reclamation $reclamation)
    {
        $deleteForm = $this->createDeleteForm($reclamation);
        $editForm = $this->createForm('ReclamationBundle\Form\ReclamationType', $reclamation);
        $editForm->handleRequest($request);
       $nomCon = $reclamation->getnomConcerne();
        $em = $this->getDoctrine()->getManager();
       $user = $em->getRepository('UserBundle:User')->findBy(array('username'=>$nomCon));
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
           /* $user->setEnabled((bool)0);
            $em->persist($user);
            $em->flush();*/
            return $this->redirectToRoute('crudRec_edit', array('id' => $reclamation->getId()));
        }

        return $this->render('reclamation/bloquer.html.twig', array(
            'reclamation' => $reclamation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $user,
        ));
    }
    public function indexAdminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $iduser = $this->getUser()->getid();
        $reclamations = $em->getRepository('ReclamationBundle:Reclamation')->findAll();
        return $this->render('reclamation/indexAd.html.twig', array(
            'reclamations' => $reclamations,
        ));
    }
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
  $iduser = $this->getUser()->getid();
        $reclamations = $em->getRepository('ReclamationBundle:Reclamation')->findby(array('idReclamant'=>$iduser));
        return $this->render('reclamation/index.html.twig', array(
            'reclamations' => $reclamations,
        ));
    }

    /**
     * Creates a new reclamation entity.
     *
     */
    public function newAction(Request $request)
    {
        $i = 0 ;
        $reclamation = new Reclamation();
        $form = $this->createForm('ReclamationBundle\Form\ReclamationType', $reclamation);
        $form->handleRequest($request);
        $user = $this->getUser();
        $iduser = $user->getid();
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $reclamation->setIdReclamant($iduser);
            $reclamation->setStatut('non traitee');
            $em->persist($reclamation);
            $em->flush();
            /* $reclamations = $em->getRepository('ReclamationBundle:Reclamation')->find($reclamation->getnomConcerne());
             //for($j=0;$j<$reclamations-;$j++){
               //   $i++;
            // }
             if($i>5) {
                 $userbloque = $em->getRepository('UserBundle:User')->find($reclamation->getnomConcerne());
                 $userbloque->setenabled(0);
             }*/

            return $this->redirectToRoute('crudRec_show', array('id' => $reclamation->getId()));
        }

        return $this->render('reclamation/new.html.twig', array(
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ));

    }

    /**
     * Finds and displays a reclamation entity.
     *
     */
    public function showAction(Reclamation $reclamation)
    {
        $deleteForm = $this->createDeleteForm($reclamation);

        return $this->render('reclamation/show.html.twig', array(
            'reclamation' => $reclamation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reclamation entity.
     *
     */
    public function editAction(Request $request, Reclamation $reclamation)
    {
        $deleteForm = $this->createDeleteForm($reclamation);
        $editForm = $this->createForm('ReclamationBundle\Form\ReclamationType', $reclamation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('crudRec_edit', array('id' => $reclamation->getId()));
        }

        return $this->render('reclamation/edit.html.twig', array(
            'reclamation' => $reclamation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reclamation entity.
     *
     */
    public function deleteAction(Request $request, Reclamation $reclamation)
    {
        $form = $this->createDeleteForm($reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reclamation);
            $em->flush();
        }

        return $this->redirectToRoute('crudRec_index');
    }

    /**
     * Creates a form to delete a reclamation entity.
     *
     * @param Reclamation $reclamation The reclamation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reclamation $reclamation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('crudRec_delete', array('id' => $reclamation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
