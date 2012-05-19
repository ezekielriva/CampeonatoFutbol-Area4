<?php

namespace Area4\CampeonatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\novedad;
use Area4\CampeonatoBundle\Form\novedadType;
use Area4\CampeonatoBundle\Entity\Partido;

/**
 * novedad controller.
 *
 * @Route("/novedad")
 */
class novedadController extends Controller
{
    /**
     * Lists all novedad entities.
     *
     * @Route("/", name="novedad")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4CampeonatoBundle:novedad')->findAll();

        return array('entities' => $entities);
    }

    /**
     * @route("/verNovedad/{partido_id}", name="verNovedad")
     * @template()
     * @ Method("post")
     */
    public function verNovedadAction($partido_id) {
        $em = $this->getDoctrine()->getEntityManager();
        $partido    = $em->getReference('Area4CampeonatoBundle:Partido', $partido_id);
        /* @var $partido Partido */
        if(!$partido) throw $this->createNotFoundException('No se encontro el partido buscado.');
        $novedades = $partido->getNovedades();
        /* @var $novedades novedad */

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            // aqui se verifica que estra una nueva novedad
            // y guardo
            $novedad = new novedad();
            $form = $this->createForm(new novedadType(), $novedad);
            $form->bindRequest($request); // Cargo la novedad primero
            $jugadores = $partido->getJugador();
            $jug = $jugadores->contains($novedad->getJugador());
            if(!$jug) {
                $this->get('session')->setFlash('error', 'Ingreso erroneamente los datos de la novedad. Compruebelos.');    
            } else {
                $novedad->setPartido($partido);
                $partido->addnovedad($novedad);
                $em->persist($partido);
                $em->flush();    
            }
        }

        $novNueva = new novedad();
        $novNueva->setPartido($partido);
        $form = $this->createForm(new novedadType(), $novNueva);
        return array(
                'entity' => $novedades,
                'id_partido' => $partido_id,
                'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new novedad entity.
     *
     * @Route("/new", name="novedad_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new novedad();
        $em = $this->getDoctrine()->getEntityManager();
        /*$jug    = $em->getRepository('Area4CampeonatoBundle:Jugador')->equipoPartidoCategoria(null,1,null);
        $entity->setJugador($jug);*/
        $form   = $this->createForm(new novedadType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new novedad entity.
     *
     * @Route("/create", name="novedad_create")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:novedad:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new novedad();
        $request = $this->getRequest();
        $form    = $this->createForm(new novedadType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('novedad_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing novedad entity.
     *
     * @Route("/{id}/edit", name="novedad_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:novedad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find novedad entity.');
        }

        $editForm = $this->createForm(new novedadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing novedad entity.
     *
     * @Route("/{id}/update", name="novedad_update")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:novedad:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:novedad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find novedad entity.');
        }

        $editForm   = $this->createForm(new novedadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('novedad_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a novedad entity.
     *
     * @Route("/{id}/{id_partido}/delete", name="novedad_delete")
     * @ Method("post")
     */
    public function deleteAction($id, $id_partido)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Area4CampeonatoBundle:novedad')->find($id);
        if (!$entity) throw $this->createNotFoundException('Unable to find novedad entity.');
        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('partido_edit', array('id' => $id_partido)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

}
