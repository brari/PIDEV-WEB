<?php

namespace FrontOffice\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AnnuaireBundle\Form\CommentType;

class CommentController extends Controller {

    public function updateAction(Request $request, $comment) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AnnuaireBundle:Comment')->find($comment);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
        }

        $form = $this->createForm(CommentType::class, $entity, array(
            'action' => $this->generateUrl('forum_comment_edit', array('comment' => $entity->getId())),
            'method' => 'post',));
        $form->handleRequest($request);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        if ($form->isValid()) {
            if($entity->getComment() != ''){
            $em->flush();
            $response->setContent(json_encode([ 'error' => false,]));
            $this->addFlash('success', 'Commentaire modifier avec succes.');
            }else{
                $response->setContent(json_encode([ 'error' => false,]));
                $this->addFlash('info', 'Le commentaire ne doit pas être vide.');
            }
//            return $response;
            return $this->redirectToRoute('subject_show', array('subject' => $entity->getSubject()->getId()));
        } else {
            $content = $this->renderView('@FrontOfficeForumBundle/Comment/edit.html.twig', array('entity' => $entity, 'form' => $form->createView(),));
            $response->setContent(json_encode([ 'title' => 'Modifier Commentaire',
                'content' => $content]));
            return $response;
        }
    }

    public function deleteAction(Request $request, $comment) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AnnuaireBundle:Comment')->find($comment);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
        }
        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('forum_comment_delete', array('comment' => $entity->getId())))
                ->setMethod('post')
                ->getForm();
        $form->handleRequest($request);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        if ($form->isValid()) {
            $subject = $entity->getSubject()->getId();
            $em->remove($entity);
            $em->flush();
            $response->setContent(
                    json_encode([
                'error' => false,
                    ])
            );
            $this->addFlash('success', 'Le commentaire supprimer avec succes.');
//            return $response;
            return $this->redirectToRoute('subject_show', array('subject' => $subject));
        } else {
            $content = $this->renderView('@FrontOfficeForumBundle/Comment/delete.html.twig', array('entity' => $entity, 'form' => $form->createView()));
            $response->setContent(json_encode([ 'title' => 'Supprimer Commentaire', 
                'content' => $content]));
            return $response;
        }
    }

}
