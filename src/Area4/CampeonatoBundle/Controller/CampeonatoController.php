<?php

namespace Area4\CampeonatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\Campeonato;
use Area4\CampeonatoBundle\Form\CampeonatoType;

/**
 * Campeonato controller.
 *
 * @Route("/campeonato")
 */
class CampeonatoController extends Controller
{
    /**
     * Lists all Campeonato entities.
     *
     * @Route("/", name="campeonato")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4CampeonatoBundle:Campeonato')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Campeonato entity.
     *
     * @Route("/{id}/show", name="campeonato_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Campeonato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campeonato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Campeonato entity.
     *
     * @Route("/new", name="campeonato_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Campeonato();
        $form   = $this->createForm(new CampeonatoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Campeonato entity.
     *
     * @Route("/create", name="campeonato_create")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Campeonato:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Campeonato();
        $request = $this->getRequest();
        $form    = $this->createForm(new CampeonatoType(), $entity);
        $form->bindRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect(
                    $this->generateUrl('campeonato'));
        }
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Campeonato entity.
     *
     * @Route("/{id}/edit", name="campeonato_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Campeonato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campeonato entity.');
        }

        $editForm = $this->createForm(new CampeonatoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Campeonato entity.
     *
     * @Route("/{id}/update", name="campeonato_update")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Campeonato:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Campeonato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campeonato entity.');
        }

        $editForm   = $this->createForm(new CampeonatoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('campeonato_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Campeonato entity.
     *
     * @Route("/{id}/delete", name="campeonato_delete")
     * @ Method("post")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Area4CampeonatoBundle:Campeonato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campeonato entity.');
        }

        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('campeonato'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    
}
