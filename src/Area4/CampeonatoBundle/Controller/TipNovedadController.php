<?php

namespace Area4\CampeonatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\TipNovedad;
use Area4\CampeonatoBundle\Form\TipNovedadType;

/**
 * TipNovedad controller.
 *
 * @Route("/tipnovedad")
 */
class TipNovedadController extends Controller
{
    /**
     * Lists all TipNovedad entities.
     *
     * @Route("/", name="tipnovedad")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4CampeonatoBundle:TipNovedad')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a TipNovedad entity.
     *
     * @Route("/{id}/show", name="tipnovedad_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:TipNovedad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipNovedad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new TipNovedad entity.
     *
     * @Route("/new", name="tipnovedad_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TipNovedad();
        $form   = $this->createForm(new TipNovedadType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new TipNovedad entity.
     *
     * @Route("/create", name="tipnovedad_create")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:TipNovedad:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new TipNovedad();
        $request = $this->getRequest();
        $form    = $this->createForm(new TipNovedadType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipnovedad_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing TipNovedad entity.
     *
     * @Route("/{id}/edit", name="tipnovedad_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:TipNovedad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipNovedad entity.');
        }

        $editForm = $this->createForm(new TipNovedadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing TipNovedad entity.
     *
     * @Route("/{id}/update", name="tipnovedad_update")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:TipNovedad:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:TipNovedad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipNovedad entity.');
        }

        $editForm   = $this->createForm(new TipNovedadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipnovedad_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a TipNovedad entity.
     *
     * @Route("/{id}/delete", name="tipnovedad_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('Area4CampeonatoBundle:TipNovedad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipNovedad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipnovedad'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
