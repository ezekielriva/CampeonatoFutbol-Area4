<?php

namespace Area4\ContableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\ContableBundle\Entity\Tipo;
use Area4\ContableBundle\Form\TipoType;

/**
 * Tipo controller.
 *
 * @Route("/tipo")
 */
class TipoController extends Controller
{
    /**
     * Lists all Tipo entities.
     *
     * @Route("/", name="tipo")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4ContableBundle:Tipo')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Displays a form to create a new Tipo entity.
     *
     * @Route("/new", name="tipo_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tipo();
        $form   = $this->createForm(new TipoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Tipo entity.
     *
     * @Route("/create", name="tipo_create")
     * @Method("post")
     * @Template("Area4ContableBundle:Tipo:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Tipo();
        $request = $this->getRequest();
        $form    = $this->createForm(new TipoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipo_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Tipo entity.
     *
     * @Route("/{id}/edit", name="tipo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:Tipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tipo entity.');
        }

        $editForm = $this->createForm(new TipoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Tipo entity.
     *
     * @Route("/{id}/update", name="tipo_update")
     * @Method("post")
     * @Template("Area4ContableBundle:Tipo:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:Tipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tipo entity.');
        }

        $editForm   = $this->createForm(new TipoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tipo entity.
     *
     * @Route("/{id}/delete", name="tipo_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('Area4ContableBundle:Tipo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tipo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipo'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
