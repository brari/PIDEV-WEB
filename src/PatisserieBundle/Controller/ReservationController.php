<?php

namespace PatisserieBundle\Controller;

use PatisserieBundle\Entity\Patisserie;
use PatisserieBundle\Entity\Reservation;
use PatisserieBundle\PatisserieBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;
use UserBundle\Entity\User;

/**
 * Reservation controller.
 *
 */
class ReservationController extends Controller
{
    /**
     * Lists all reservation entities.
     *
     */
    public function afficherAction()
    {
        $id=$this->getUser()->getid();
        //$id=$request->get('id');
        $em = $this->getDoctrine()->getManager();

        $reservations = $em->getRepository('PatisserieBundle:Reservation')->findMyReservations($id);

        return $this->render('@Patisserie/Client/reservation.html.twig', array(
            'reservations' => $reservations,
        ));
    }

    /**
     * Lists all reservation entities for patissier.
     *
     */
    public function afficherPatAction()
    {
        $id=$this->getUser()->getid();
        $em = $this->getDoctrine()->getManager();

        $reservations = $em->getRepository('PatisserieBundle:Reservation')->allReservations($id);

        return $this->render('@Patisserie/Patissier/reservation.html.twig', array(
            'reservations' => $reservations,
        ));
    }

    /**
     * Creates a new reservation entity.
     *
     */
    public function newAction(Request $request)
    {
        $idp=$request->get('id');
        $idu=$this->getUser()->getid();
        $reservation = new Reservation();
        $form = $this->createForm('PatisserieBundle\Form\ReservationType', $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('UserBundle:User')->find($idu);
            $patisserie=$em->getRepository('PatisserieBundle:Patisserie')->find($idp);

            $reservation->setIduser($user);
            $reservation->setIdpat($patisserie);

            $em->persist($reservation);
            $em->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('@Patisserie/Client/newreservation.html.twig', array(
            'reservation' => $reservation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reservation entity.
     *
     */
    public function editAction(Request $request)
    {
        $id=$request->get('id');
        $reservation=$this->getDoctrine()->getRepository(Reservation::class)->find($id);
        $deleteForm = $this->createDeleteForm($reservation);
        $editForm = $this->createForm('PatisserieBundle\Form\ReservationType', $reservation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('@Patisserie/Client/modifierres.html.twig', array(
            'reservation' => $reservation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reservation entity.
     *
     */
    public function deleteAction(Request $request)
    {
        $id=$request->get('id');
        $reservation=$this->getDoctrine()->getRepository(Reservation::class)->find($id);
        $form = $this->createDeleteForm($reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }

    /**
     * Creates a form to delete a reservation entity.
     *
     * @param Reservation $reservation The reservation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_delete', array('id' => $reservation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
