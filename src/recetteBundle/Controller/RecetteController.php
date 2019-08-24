<?php

namespace recetteBundle\Controller;

use AnnuaireBundle\Entity\Recette;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Recette controller.
 *
 */
class RecetteController extends Controller
{
    /**
     * Lists all recette entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recettes = $em->getRepository('AnnuaireBundle:Recette')->findAll();

        return $this->render('recette/index.html.twig', array(
            'recettes' => $recettes,
        ));
    }

    /**
     * Creates a new recette entity.
     *
     */
    public function addAction(Request $request){

            $recette = new Recette();
            $entityManager = $this->getDoctrine()->getManager();
            $recette->setNom($request->get('designation'));
            $recette->setDescription($request->get('description'));
            $recette->setPhoto($request->get('photo'));
             $recette->setDate($request->get('date'));
            if($request->get('action')==1){$recette->setAction("sucree");}
        if($request->get('action')==2){$recette->setAction("salee");}
        if($request->get('action')==3){$recette->setAction("gateaux");}
            $recette->setEtat($request->get('etat'));
        $recette->setRating(1);
            $entityManager->persist($recette);
            $entityManager->flush();

        $em = $this->getDoctrine()->getManager();

        $recettes = $em->getRepository('AnnuaireBundle:Recette')->findAll();

        return $this->render('recette/new.html.twig', array(
            'recettes' => $recettes,
        ));

    }
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $recettes = $em->getRepository('AnnuaireBundle:Recette')->findAll();

        return $this->render('recette/new.html.twig', array(
            'recettes' => $recettes,
        ));
        /*
        $recette = new Recette();
        $form = $this->createForm('AnnuaireBundle\Form\RecetteType', $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recette);
            $em->flush();

            return $this->redirectToRoute('recette_show', array('id' => $recette->getId()));
        }

        return $this->render('recette/new.html.twig', array(
            'recette' => $recette,
            'form' => $form->createView(),
        ));*/
    }

    /**
     * Finds and displays a recette entity.
     *
     */
    public function showAction(Recette $recette)
    {
        $deleteForm = $this->createDeleteForm($recette);

        return $this->render('recette/show.html.twig', array(
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

            return $this->redirectToRoute('recette_edit', array('id' => $recette->getId()));
        }

        return $this->render('recette/edit.html.twig', array(
            'recette' => $recette,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a recette entity.
     * @param Recette $recette
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request)
    {

        $designation = $request->get('recette');
        $repository = $this->getDoctrine()->getManager()->getRepository('AnnuaireBundle:Recette');
        $element = $repository->findOneBy(array('nom' => $designation ));
        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->flush();
          return $this->redirectToRoute('recette_new');

    }

    public function detailAction(Request $request){
        $name = $request->get('name');
        $em = $this->getDoctrine()->getManager();

        /* $repository = $this->getDoctrine()->getManager()->getRepository('AnnuaireBundle:Recette');
         $element = $repository->findOneBy(array('nom' => $name));*/
        $dql = "SELECT p  FROM AnnuaireBundle:Recette p
                            WHERE p.nom = :nom ";
        $element = $em->createQuery($dql)
            ->setParameter('nom',$name)
            ->getSingleResult();
        $resultat = array();
        array_push($resultat,$element->getNom());
        array_push($resultat,$element->getDescription());
        array_push($resultat,$element->getPhoto());
        array_push($resultat,$element->getDate());
        array_push($resultat,$element->getEtat());
        array_push($resultat,$element->getAction());
        return new JsonResponse($resultat);
    }
}
