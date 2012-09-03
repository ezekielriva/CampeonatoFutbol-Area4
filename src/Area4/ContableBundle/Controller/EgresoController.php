<?php

namespace Area4\ContableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\ContableBundle\Entity\Egreso;
use Area4\ContableBundle\Form\EgresoType;
use Area4\ContableBundle\Form\Filtro\ReporteType;

/**
 * Egreso controller.
 *
 * @Route("/egreso")
 */
class EgresoController extends Controller
{
    /**
     * Lists all Egreso entities.
     *
     * @Route("/", name="egreso")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4ContableBundle:Egreso')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Egreso entity.
     *
     * @Route("/{id}/show", name="egreso_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:Egreso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Egreso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Egreso entity.
     *
     * @Route("/new", name="egreso_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Egreso();
        $form   = $this->createForm(new EgresoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Egreso entity.
     *
     * @Route("/create", name="egreso_create")
     * @Method("post")
     * @Template("Area4ContableBundle:Egreso:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Egreso();
        $request = $this->getRequest();
        $form    = $this->createForm(new EgresoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $user = $this->container->get('security.context')->getToken()->getUser();
            $entity->setUsuario($user);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('egreso_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Egreso entity.
     *
     * @Route("/{id}/edit", name="egreso_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:Egreso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Egreso entity.');
        }

        $editForm = $this->createForm(new EgresoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Egreso entity.
     *
     * @Route("/{id}/update", name="egreso_update")
     * @Method("post")
     * @Template("Area4ContableBundle:Egreso:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:Egreso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Egreso entity.');
        }

        $editForm   = $this->createForm(new EgresoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('egreso_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Egreso entity.
     *
     * @Route("/{id}/delete", name="egreso_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('Area4ContableBundle:Egreso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Egreso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('egreso'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Lists todos los Egresos entre 2 fechas
     *
     * @Route("/reporte", name="egreso_reporte")
     * @Template()
     */
    public function reporteAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $egresoForm = new \Area4\ContableBundle\Util\EgresoForm(new \DateTime('now'), new \DateTime('now'));
        $form = $this->createForm(new ReporteType(),$egresoForm );

        $request = $this->getRequest();
        $form->bindRequest($request);

        $egresos = $em->getRepository('Area4ContableBundle:Egreso')->reporte($egresoForm->getFechaInicio(), $egresoForm->getFechaFin());

        $total = 0;
        foreach ($egresos as $egreso) {
            $total += $egreso->getImporte();
        }

        return array(
            'egresos' => $egresos,
            'fecha_inicio' => $egresoForm->getFechaInicio(),
            'fecha_fin' => $egresoForm->getFechaFin(),
            'total' => $total
            );
    }
    /**
     * Lists todos los Egresos entre 2 fechas
     *
     * @Route("/reporte/form", name="egreso_reporte_form")
     * @Template()
     */
    public function reporteFormAction()
    {
        $egresoForm = new \Area4\ContableBundle\Util\EgresoForm(new \DateTime('now'), new \DateTime('now'));
        $form = $this->createForm(new ReporteType(),$egresoForm );

        return array('form' => $form->createView());
    }
}
