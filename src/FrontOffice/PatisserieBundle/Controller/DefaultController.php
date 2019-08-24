<?php

namespace FrontOffice\PatisserieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AnnuaireBundle\Entity\Recette;
use AnnuaireBundle\Entity\CommentRecette;
use AnnuaireBundle\Form\CommentRecetteType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@FrontOfficePatisserie/Default/index.html.twig');
    }
    
    public function recetteAction(Recette $recette)
    {
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('AnnuaireBundle:CommentRecette')->findBy(array('recette' => $recette));
        
        return $this->render('@FrontOfficePatisserie/Default/recette.html.twig', [
            'recette' => $recette,
            'comments' => $comments
        ]);
    }
    
    public function addCommentAction(Request $request, Recette $recette) {
        $em = $this->getDoctrine()->getManager();
        
        
        if ($this->get('security.token_storage')->getToken()->getUser() != 'anon.') {
            $comment = new CommentRecette();

           
            $comment->setComment($request->request->get('comment'));
            $comment->setRecette($recette);
            $comment->setIduser($this->get('security.token_storage')->getToken()->getUser());

            $em->persist($comment);
            $em->flush();

            if ($request->request->get('mailAlert') != null) {

            }

            $this->addFlash('success', 'Votre commentaire a été ajouté avec succès.');
        } else {
            $this->addFlash('success', 'Erreur, votre commentaire n\'a pas été ajouté.');
        }

        return new RedirectResponse($this->generateUrl('front_office_patisserie_recette', array('id' => $recette->getId())));
    }
    
    public function updateAction(Request $request, $comment) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AnnuaireBundle:CommentRecette')->find($comment);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
        }

        $form = $this->createForm(CommentRecetteType::class, $entity, array(
            'action' => $this->generateUrl('front_office_patisserie_comment_edit', array('comment' => $entity->getId())),
            'method' => 'post',));
        $form->handleRequest($request);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        if ($form->isValid()) {
            if($entity->getComment() != ''){
            $em->flush();
            $response->setContent(json_encode([ 'error' => false,]));
            $this->addFlash('success', 'Commentaire a été modifier avec succes.');
            }else{
                $response->setContent(json_encode([ 'error' => false,]));
                $this->addFlash('info', 'Le commentaire ne doit pas être vide.');
            }
//            return $response;
            return $this->redirectToRoute('front_office_patisserie_recette', array('id' => $entity->getRecette()->getId()));
        } else {
            $content = $this->renderView('@FrontOfficePatisserie/Default/edit.html.twig', array('entity' => $entity, 'form' => $form->createView(),));
            $response->setContent(json_encode([ 'title' => 'Modifier Commentaire',
                'content' => $content]));
            return $response;
        }
    }

    public function deleteAction(Request $request, $comment) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AnnuaireBundle:CommentRecette')->find($comment);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
        }
        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('front_office_patisserie_comment_delete', array('comment' => $entity->getId())))
                ->setMethod('post')
                ->getForm();
        $form->handleRequest($request);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        if ($form->isValid()) {
            $em->remove($entity);
            $em->flush();
            $response->setContent(
                    json_encode([
                'error' => false,
                    ])
            );
            $this->addFlash('success', 'Le commentaire a été supprimer avec succes.');
//            return $response;
            return $this->redirectToRoute('front_office_patisserie_recette', array('id' => $entity->getRecette()->getId()));
        } else {
            $content = $this->renderView('@FrontOfficePatisserie/Default/delete.html.twig', array('entity' => $entity, 'form' => $form->createView()));
            $response->setContent(json_encode([ 'title' => 'Supprimer Commentaire', 
                'content' => $content]));
            return $response;
        }
    }
}
