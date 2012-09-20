<?php

namespace Area4\CampeonatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\Equipo;
use Area4\CampeonatoBundle\Form\EquipoType;

/**
 * Equipo controller.
 *
 * @Route("/equipo")
 */
class EquipoController extends Controller
{
    /**
     * Lists all Equipo entities.
     *
     * @Route("/", name="equipo")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4CampeonatoBundle:Equipo')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Equipo entity.
     *
     * @Route("/{id}/show", name="equipo_show")
     * @Template()
     * @todo Agregar listado de jugadores.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $equipo = $em->getRepository('Area4CampeonatoBundle:Equipo')->find($id);
        /*$jug = $em->getRepository('Area4CampeonatoBundle:Jugador')->equipoPartidoCategoria($id,null,null);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        */
        $jugadores = $em->getRepository('Area4CampeonatoBundle:Jugador')->findByEquipo($equipo->getId());
        return array(
            'entity'      => $equipo,
            'jugadores'   => $jugadores,
            //'total'       => count($jug),
            //'delete_form' => $deleteForm->createView(),        
            );
    }

    /**
     * Displays a form to create a new Equipo entity.
     *
     * @Route("/new", name="equipo_new")
     * @Template()
     */
    public function newAction()
    {
        $equipo = new Equipo();
        $form   = $this->createForm(new EquipoType(), $equipo);

        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($user->getId());

        if ($jugador->hasEquipo()){
            throw $this->createNotFoundException('Usted ya pertenese a un equipo.');
        }

        return array(
            'entity' => $equipo,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Equipo entity.
     *
     * @Route("/create", name="equipo_create")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Equipo:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Equipo();
        $request = $this->getRequest();
        $form    = $this->createForm(new EquipoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            //$entity->setPath($this->get('kernel')->getRootDir()."/../web/img/equipos");
	        //$entity->upload();

            $em = $this->getDoctrine()->getEntityManager();
            $user = $this->container->get('security.context')->getToken()->getUser();
            $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($user->getId());

            $entity->addJugador($jugador);

            $jugador->setEquipo($entity);
            $em->persist($jugador);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('equipo_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Equipo entity.
     *
     * @Route("/{id}/edit", name="equipo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Equipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipo entity.');
        }

        $editForm = $this->createForm(new EquipoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Equipo entity.
     *
     * @Route("/{id}/update", name="equipo_update")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Equipo:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Equipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Equipo entity.');
        }

        $editForm   = $this->createForm(new EquipoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('equipo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Equipo entity.
     *
     * @Route("/{id}/delete", name="equipo_delete")
     * @ Method("post")
     *
     */
    public function deleteAction($id)
    {
//        $form = $this->createDeleteForm($id);
//        $request = $this->getRequest();
//
//        $form->bindRequest($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('Area4CampeonatoBundle:Equipo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Equipo entity.');
            }

            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('equipo'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     *
     * @Route("/{id}/delete", name="equipo_delete")
     * @ Method("post")
     * @Template("Area4CampeonatoBundle:Equipo:toPartido.html.twig")
     */
    public function equipoToPartidoAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $partido    = $em->getReference('Area4CampeonatoBundle:Partido', $partido_id);
        /* @var $partido Partido */
        if(!$partido) throw $this->createNotFoundException('Unable to find partido entity.');
        $novedades = $partido->getNovedades();
        /* @var $novedades novedad */

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            // aqui se verifica que estra una nueva novedad
            // y guardo
            $novedad = new novedad();

            $form = $this->createForm(new novedadType(), $novedad);
            $form->bindRequest($request); // Cargo la novedad primero
            $novedad->setPartido($partido);
            $partido->addnovedad($novedad);
            //if ($form->isValid()) {
                $em->persist($partido);
                $em->flush();
                //return $this->redirect($this->generateUrl('partido_edit', array('id' => $partido_id)));
            //}
        }

        $jugador = new \Area4\CampeonatoBundle\Entity\Jugador();
        $form = $this->createForm(new \Area4\CampeonatoBundle\Form\JugadorType(), $jugador);
        return array(
                'entity' => $novedades,
                'id_partido' => $partido_id,
                'form'   => $form->createView(),
        );
    }


    /**
            ACTIONS PARA EL FRONT
    */
    /**
     * Finds and displays a Equipo entity.
     *
     * @Route("/mostrar", name="equipo_show_front")
     * @Template("Area4CampeonatoBundle:Equipo:show.html.twig")
     */
    public function showEquipoFrontAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $id = $request->query->get('id');
        $equipo = $em->getRepository('Area4CampeonatoBundle:Equipo')->find($id);

        $jugadores = $em->getRepository('Area4CampeonatoBundle:Jugador')->findByEquipo($equipo->getId());
        return array(
            'entity'      => $equipo,
            'jugadores'   => $jugadores, 
            );
    }

    /**
     * Lista todos los equipos
     *
     * @Route("/equipos", name="equipo_index_front")
     * @Template()
     */
    public function indexEquipoFrontAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4CampeonatoBundle:Equipo')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $entities, 
                $this->get('request')->query->get('page', 1),/*page number*/
                20/*limit per page*/
            );

        return array('pagination' => $pagination);
    }

}
