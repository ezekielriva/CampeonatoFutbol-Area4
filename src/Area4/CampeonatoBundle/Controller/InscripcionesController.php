<?php

namespace Area4\CampeonatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\Inscripciones;
use Area4\CampeonatoBundle\Form\InscripcionesType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Inscripciones controller.
 *
 * @Route("/inscripciones")
 */
class InscripcionesController extends Controller
{
    /**
     * Lists all Inscripciones entities.
     *
     * @Route("/", name="inscripciones")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4CampeonatoBundle:Inscripciones')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Inscripciones entity.
     *
     * @Route("/{id}/show", name="inscripciones_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Inscripciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Inscripciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Inscripciones entity.
     *
     * @Route("/abrir/{idCampeonato}", name="inscripciones_abrir")
     * @Template()
     */
    public function abrirInscripcionesAction($idCampeonato)
    {
        $inscripcion = new Inscripciones();
        
        $em = $this->getDoctrine()->getEntityManager();
        $campeonato = $em->getRepository('Area4CampeonatoBundle:Campeonato')->findOneById($idCampeonato);
        $inscripcion->setCampeonato($campeonato);

        $form   = $this->createForm(new InscripcionesType(), $inscripcion);

        return array(
            'entity' => $inscripcion,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Inscripciones entity.
     *
     * @Route("/create", name="inscripciones_create")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Inscripciones:abrirInscripciones.html.twig")
     */
    public function createAction()
    {
        $entity  = new Inscripciones();
        $request = $this->getRequest();
        $form    = $this->createForm(new InscripcionesType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inscripciones_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Inscripciones entity.
     *
     * @Route("/{id}/edit", name="inscripciones_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Inscripciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Inscripciones entity.');
        }

        $editForm = $this->createForm(new InscripcionesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Inscripciones entity.
     *
     * @Route("/{id}/update", name="inscripciones_update")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Inscripciones:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Inscripciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Inscripciones entity.');
        }

        $editForm   = $this->createForm(new InscripcionesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('inscripciones_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Inscripciones entity.
     *
     * @Route("/{id}/delete", name="inscripciones_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('Area4CampeonatoBundle:Inscripciones')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Inscripciones entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('inscripciones'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
