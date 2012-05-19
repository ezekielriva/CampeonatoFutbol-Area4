<?php

namespace Area4\CampeonatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\Arbitro;
use Area4\CampeonatoBundle\Entity\Partido;
use Area4\CampeonatoBundle\Form\ArbitroType;
use Area4\CampeonatoBundle\Form\SelectArbitroType;


/**
 * Arbitro controller.
 *
 * @Route("/arbitro")
 */
class ArbitroController extends Controller
{
    /**
     * Lists all Arbitro entities.
     *
     * @Route("/", name="arbitro")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4CampeonatoBundle:Arbitro')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Arbitro entity.
     *
     * @Route("/{id}/show", name="arbitro_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Arbitro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Arbitro entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Arbitro entity.
     *
     * @Route("/new", name="arbitro_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Arbitro();
        $form   = $this->createForm(new ArbitroType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Arbitro entity.
     *
     * @Route("/create", name="arbitro_create")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Arbitro:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Arbitro();
        $request = $this->getRequest();
        $form    = $this->createForm(new ArbitroType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('arbitro_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Arbitro entity.
     *
     * @Route("/{id}/edit", name="arbitro_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Arbitro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Arbitro entity.');
        }

        $editForm = $this->createForm(new ArbitroType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Arbitro entity.
     *
     * @Route("/{id}/update", name="arbitro_update")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Arbitro:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Arbitro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Arbitro entity.');
        }

        $editForm   = $this->createForm(new ArbitroType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('arbitro_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Arbitro entity.
     *
     * @Route("/{id}/delete", name="arbitro_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('Area4CampeonatoBundle:Arbitro')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Arbitro entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('arbitro'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Selecciona los arbitros para determinado partido
     * @param integer $id
     * @Route("/select/{id}", name="arbitro_select")
     * @Template("Area4CampeonatoBundle:Arbitro:select.html.twig")
     * @Method("post")
     */
    public function selectAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Area4CampeonatoBundle:Arbitro')->findAll();
        /* @var $entity Arbitro */
        if (!$entity) throw $this->createNotFoundException('No se pudo encontrar los arbitros.');

        $form = $this->createForm(new SelectArbitroType(), $entity);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST'){
            $form->bindRequest($request);
            $arbitro1 = $form->get('arbitro1')->getData();
            $arbitro2 = $form->get('arbitro2')->getData();
            $partido = $em->getRepository('Area4CampeonatoBundle:Partido')->find($id);
            /* @var $partido Partido */
            $partido->addArbitro($arbitro1);
            $partido->addArbitro($arbitro2);
            $em->persist($partido);
            $em->flush();
            return $this->redirect($this->generateUrl('partido_edit',array('id'=>$id)));
        }

        return array(
            'entity'      => $entity,
            'id_partido'  => $id,
            'form'   => $form->createView(),
        );
    }
}
