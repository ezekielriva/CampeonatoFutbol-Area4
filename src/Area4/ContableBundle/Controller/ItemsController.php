<?php

namespace Area4\ContableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\ContableBundle\Entity\Items;
use Area4\ContableBundle\Form\ItemsType;

/**
 * Items controller.
 *
 * @Route("/items")
 */
class ItemsController extends Controller
{
    /**
     * Lists all Items entities.
     *
     * @Route("/", name="items")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4ContableBundle:Items')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Items entity.
     *
     * @Route("/{id}/show", name="items_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:Items')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Items entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Items entity.
     *
     * @Route("/new", name="items_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Items();
        $form   = $this->createForm(new ItemsType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Items entity.
     *
     * @Route("/create", name="items_create")
     * @Method("post")
     * @Template("Area4ContableBundle:Items:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Items();
        $request = $this->getRequest();
        $form    = $this->createForm(new ItemsType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('items_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Items entity.
     *
     * @Route("/{id}/edit", name="items_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:Items')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Items entity.');
        }

        $editForm = $this->createForm(new ItemsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Items entity.
     *
     * @Route("/{id}/update", name="items_update")
     * @Method("post")
     * @Template("Area4ContableBundle:Items:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:Items')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Items entity.');
        }

        $editForm   = $this->createForm(new ItemsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('items_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Items entity.
     *
     * @Route("/{id}/delete", name="items_delete")
     * @ //Method("post")
     */
    public function deleteAction($id)
    {
        $doc_id=null;
	if (\is_numeric($id)) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('Area4ContableBundle:Items')->find($id);
	    $doc_id = $entity->getDocumento()->getId();
            
            if (!$entity)  throw $this->createNotFoundException('Unable to find Items entity.');

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cobrar_cuota',array('id'=>$doc_id)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
