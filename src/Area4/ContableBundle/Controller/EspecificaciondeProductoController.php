<?php

namespace Area4\ContableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\ContableBundle\Entity\EspecificaciondeProducto;
use Area4\ContableBundle\Form\EspecificaciondeProductoType;

/**
 * EspecificaciondeProducto controller.
 *
 * @Route("/especificaciondeproducto")
 */
class EspecificaciondeProductoController extends Controller
{
    /**
     * Lists all EspecificaciondeProducto entities.
     *
     * @Route("/", name="especificaciondeproducto")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4ContableBundle:EspecificaciondeProducto')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a EspecificaciondeProducto entity.
     *
     * @Route("/{id}/show", name="especificaciondeproducto_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:EspecificaciondeProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EspecificaciondeProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new EspecificaciondeProducto entity.
     *
     * @Route("/new", name="especificaciondeproducto_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EspecificaciondeProducto();
        $form   = $this->createForm(new EspecificaciondeProductoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'formName' => $form->getName(),
        );
    }

    /**
     * Creates a new EspecificaciondeProducto entity.
     *
     * @Route("/create", name="especificaciondeproducto_create")
     * @Method("post")
     * @Template("Area4ContableBundle:EspecificaciondeProducto:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new EspecificaciondeProducto();
        $request = $this->getRequest();
        $form    = $this->createForm(new EspecificaciondeProductoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('especificaciondeproducto'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing EspecificaciondeProducto entity.
     *
     * @Route("/{id}/edit", name="especificaciondeproducto_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:EspecificaciondeProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EspecificaciondeProducto entity.');
        }

        $editForm = $this->createForm(new EspecificaciondeProductoType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'formName' => $editForm->getName(),
        );
    }

    /**
     * Edits an existing EspecificaciondeProducto entity.
     *
     * @Route("/{id}/update", name="especificaciondeproducto_update")
     * @Method("post")
     * @Template("Area4ContableBundle:EspecificaciondeProducto:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:EspecificaciondeProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EspecificaciondeProducto entity.');
        }

        $editForm   = $this->createForm(new EspecificaciondeProductoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('especificaciondeproducto'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a EspecificaciondeProducto entity.
     *
     * @Route("/{id}/delete", name="especificaciondeproducto_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('Area4ContableBundle:EspecificaciondeProducto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EspecificaciondeProducto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('especificaciondeproducto'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
