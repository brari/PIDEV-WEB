<?php

namespace FrontOffice\ForumBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AnnuaireBundle\Entity\Comment;
use AnnuaireBundle\Entity\Subject;
use AnnuaireBundle\Form\SubjectType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SubjectController extends Controller {

    public function indexAction($theme) {
        $theme_id = $theme;

        $em = $this->getDoctrine()->getManager();
        $theme = $em->getRepository('AnnuaireBundle:Themes')->find($theme_id);


        $subjects = $em->getRepository('AnnuaireBundle:Subject')->findAllArray($theme_id);

        $users = count($em->getRepository('UserBundle:User')->findAll());

        if ($this->get('security.token_storage')->getToken()->getUser() != 'anon.') {
            $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        } else {
            $user = 0;
        }

        $i = 0;
        while (count($subjects) > $i) {
            $id_theme = $em->getRepository('AnnuaireBundle:Subject')->findThemeForSubject($subjects[$i]['id']);
            $subjects[$i]['lasComment'] = $em->getRepository('AnnuaireBundle:Comment')->findLastComment($subjects[$i]['id'], $id_theme[0]->getTheme());
            $i++;
        }

        $nbnotif = count($em->getRepository('AnnuaireBundle:JointNotif')->getNotifNotSee($this->get('security.token_storage')->getToken()->getUser()->getId()));
        
        $stats = array('messages' => count($em->getRepository('AnnuaireBundle:Comment')->findAll()),
            'sujets' => count($em->getRepository('AnnuaireBundle:Subject')->findAll()),
            'users' => $users,
            'sujetsParJr' => count($em->getRepository('AnnuaireBundle:Subject')->findBySujetsParJr(date('Y-m-d'))),
            'messagesParJr' => count($em->getRepository('AnnuaireBundle:comment')->findBymessagesParJr(date('Y-m-d'))),
            'usersParJr' => count($em->getRepository('UserBundle:User')->findByusersParJr(date('Y-m-d'))),
            'sujetsParVous' => count($em->getRepository('AnnuaireBundle:Subject')->findBy(array('iduser' => $user))),
            'messagesParVous' => count($em->getRepository('AnnuaireBundle:Comment')->findBy(array('iduser' => $user)))
        );

        return $this->render('@FrontOfficeForum/Subject/index.html.twig', array('subjects' => $subjects,
                    'stats' => $stats,
                    'count' => count($subjects),
                    'theme' => $theme,
            'nbnotif' => $nbnotif));
    }

    public function viewAction($subject) {
        $subject_id = $subject;
        $em = $this->getDoctrine()->getManager();
        $nbnotif = count($em->getRepository('AnnuaireBundle:JointNotif')->getNotifNotSee($this->get('security.token_storage')->getToken()->getUser()->getId()));
        
        
        $subject = $em->getRepository('AnnuaireBundle:Subject')->find($subject_id);

        $theme = $em->getRepository('AnnuaireBundle:Themes')->find($subject->getTheme());

        $comments = $em->getRepository('AnnuaireBundle:Comment')->findBy(array('subject' => $subject));


        return $this->render('@FrontOfficeForum/Subject/view.html.twig', array('subject' => $subject,
                    'theme' => $theme,
                    'comments' => $comments,
            'nbnotif' => $nbnotif));
    }

    public function addCommentAction(Request $request, $subject) {
        $em = $this->getDoctrine()->getManager();
        
        if ($this->get('security.token_storage')->getToken()->getUser() != 'anon.') {
            $comment = new Comment();

            $s = $em->getRepository('AnnuaireBundle:Subject')->find($subject);
            $t = $em->getRepository('AnnuaireBundle:Themes')->find($s->getTheme());

            $comment->setComment($request->request->get('comment'));
            $comment->setTheme($t);
            $comment->setSubject($s);
            $comment->setIduser($this->get('security.token_storage')->getToken()->getUser());

            $em->persist($comment);
            $em->flush();

            if ($request->request->get('mailAlert') != null) {
                // Send mail if you want
                // with swiftmailer
            }

            $this->addFlash('success', 'Votre commentaire a été ajouté avec succès.');
        } else {
            $this->addFlash('success', 'Erreur, votre commentaire n\'a pas été ajouté.');
        }

        return new RedirectResponse($this->generateUrl('subject_show', array('subject' => $subject)));
    }

    /*     * ******************************************* */
    /*     * ******************************************* */

    /**
     * Displays a form to create a new Subject entity.
     *
     */
    public function newAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $nbnotif = count($em->getRepository('AnnuaireBundle:JointNotif')->getNotifNotSee($this->get('security.token_storage')->getToken()->getUser()->getId()));
        $entity = new Subject();
        $form = $this->createForm(SubjectType::class, $entity, array(
            'action' => $this->generateUrl('subject_new'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $entity->setIduser($user);
            $entity->setDate(new \Datetime()); // date('Y-m-d H:s:i')
            $entity->setIsdisabled(false);
            $entity->setIsblocked(false);
            $em->persist($entity);

            $em->flush();

            $this->addFlash('success', 'Votre Sujet a été ajouté avec succès.');
            return $this->redirect($this->generateUrl('subject_show', array('subject' => $entity->getId())));
        }

        return $this->render('@FrontOfficeForum/Subject/new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
            'nbnotif' => $nbnotif
        ));
    }

    /**
     * Finds and displays a Subject entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AnnuaireBundle:Subject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('@FrontOfficeForum/Subject/show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Subject entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AnnuaireBundle:Subject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subject entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('@FrontOfficeForum/Subject/edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Subject entity.
     *
     * @param Subject $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Subject $entity) {
        $form = $this->createForm(new SubjectType(), $entity, array(
            'action' => $this->generateUrl('subject_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Subject entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AnnuaireBundle:Subject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('subject_edit', array('id' => $id)));
        }

        return $this->render('@FrontOfficeForum/Subject/edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Subject entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AnnuaireBundle:Subject')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Subject entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('subject'));
    }

    /**
     * Creates a form to delete a Subject entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('subject_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    public function AjoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $nbnotif = count($em->getRepository('AnnuaireBundle:JointNotif')->getNotifNotSee($this->get('security.token_storage')->getToken()->getUser()->getId()));
        $subject = new Subject();
        $u = new User();
        $user = $this->getUser();
        if ($request->isMethod('POST')) {
            $subject->setCore($request->get('core'));
            $subject->setTitle($request->get('title'));

            $subject->setTheme($request->get('theme'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();
        }
        return $this->render('@FrontOfficeForum/Subject/AjoutA.html.twig', array('nbnotif' => $nbnotif));
    }

    /*     * ************************************************ */
    /*     * ************************************************ */
    /*     * ************************************************ */

    public function activeAction(Request $request, $subject) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AnnuaireBundle:Subject')->find($subject);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subject entity.');
        }
        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('subject_active', array('subject' => $entity->getId())))
                ->setMethod('post')
                ->getForm();
        $form->handleRequest($request);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        if ($form->isValid()) {
            $entity->setIsdisabled(false);
            $em->persist($entity);
            $em->flush();
            $response->setContent(
                    json_encode([
                'error' => false,
                    ])
            );
            $this->addFlash('success', 'Le sujet a été activer avec succes.');
//            return $response;
            return $this->redirectToRoute('subject_show', array('subject' => $subject));
        } else {
            $content = $this->renderView('@FrontOfficeForum/Subject/enable.html.twig', array('entity' => $entity, 'form' => $form->createView()));
            $response->setContent(json_encode([ 'title' => 'Activer Sujet',
                'content' => $content]));
            return $response;
        }
    }

    public function desactiveAction(Request $request, $subject) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AnnuaireBundle:Subject')->find($subject);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subject entity.');
        }
        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('subject_desactive', array('subject' => $entity->getId())))
                ->setMethod('post')
                ->getForm();
        $form->handleRequest($request);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        if ($form->isValid()) {
            $entity->setIsdisabled(true);
            $em->persist($entity);
            $em->flush();
            $response->setContent(
                    json_encode([
                'error' => false,
                    ])
            );
            $this->addFlash('success', 'Le sujet a été désactiver avec succes.');
//            return $response;
            return $this->redirectToRoute('subject_show', array('subject' => $subject));
        } else {
            $content = $this->renderView('@FrontOfficeForum/Subject/disable.html.twig', array('entity' => $entity, 'form' => $form->createView()));
            $response->setContent(json_encode([ 'title' => 'Fermer Sujet',
                'content' => $content]));
            return $response;
        }
    }

    public function mysubjectsAction($page) {

        $maxPerPage = 10;
        $em = $this->getDoctrine()->getManager();
        $nbnotif = count($em->getRepository('AnnuaireBundle:JointNotif')->getNotifNotSee($this->get('security.token_storage')->getToken()->getUser()->getId()));
        $subjects = $em->getRepository('AnnuaireBundle:Subject')->findByUserInArray($this->get('security.token_storage')->getToken()->getUser()->getId(), $page, $maxPerPage);

        if ($this->get('security.token_storage')->getToken()->getUser() != 'anon.') {
            $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        } else {
            $user = 0;
        }
        
        $subjects_array = array();
        
        foreach ($subjects as $s) {
            $subjects_array[] = array(
                'id' => $s->getId(),
                'title' => $s->getTitle(),
                'core' => $s->getCore(),
                'date' => $s->getDate(),
                'isdisabled' => $s->getIsdisabled()
            );
        }

        $i = 0;
        while (count($subjects_array) > $i) {
            $subjects_array[$i]['nbposts'] = count($em->getRepository('AnnuaireBundle:Comment')->findNbPosts($subjects_array[$i]['id']));
            $i++;
        }

        $pagination = array('page' => $page,
            'route' => 'my_subjects',
            'pages_count' => ceil(count($subjects) / $maxPerPage),
            'route_params' => array()
        );

        return $this->render('@FrontOfficeForum/MySubjects/index.html.twig', array(
                    'subjects' => $subjects,
                    'pagination' => $pagination,
                    'nbnotif' => $nbnotif
        ));
    }
    
    public function changeStatusAction($id)
    {    
        $em = $this->getDoctrine()->getManager();

        $output_val = $em->getRepository("AnnuaireBundle:Subject")->switchState($id);
        return new Response($output_val);
    }

}
