<?php

namespace Area4\CampeonatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\Partido;
use Area4\CampeonatoBundle\Form\PartidoType;
use Area4\CampeonatoBundle\Form\PartidoEditType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Partido controller.
 *
 * @Route("/partido")
 */
class PartidoController extends Controller
{
    /**
     * Lists all Partido entities.
     *
     * @Route("/", name="partido")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4CampeonatoBundle:Partido')->partidoOrderByFecha();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Partido entity.
     *
     * @Route("/{id}/show", name="partido_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Partido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partido entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'partido'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Partido entity.
     *
     * @Route("/new", name="partido_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Partido();
        $form   = $this->createForm(new PartidoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Partido entity.
     *
     * @Route("/create", name="partido_create")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Partido:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Partido();
        $request = $this->getRequest();
        $form    = $this->createForm(new PartidoType(), $entity);
        $form->bindRequest($request);

        if ( $form->isValid() ) {
            $entity->setResultadol(0); 
            $entity->setResultadov(0);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('partido_show', array('id' => $entity->getId())));    
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Partido entity.
     *
     * @Route("/{id}/edit", name="partido_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Partido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partido entity.');
        }

        $editForm = $this->createForm(new PartidoEditType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Partido entity.
     *
     * @Route("/{id}/update", name="partido_update")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Partido:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Partido')->find($id);
        $arbitro = new \Area4\CampeonatoBundle\Entity\Arbitro();
        if (!$entity) throw $this->createNotFoundException('No se encontro el Partido buscado.');

        $form   = $this->createForm(new PartidoType(), $entity);
        //$formArbitro = $this->createForm(new \Area4\CampeonatoBundle\Form\ArbitroType(), $arbitro);

        //$deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $form->bindRequest($request); //Tengo los datos
        //$formArbitro->bindRequest($request);
        if ($request->getMethod() == 'POST') {
            
            $resl = $this->get('request')->request->get('area4_campeonatobundle_partidotype[resultadol]',null,true);
            $resv = $this->get('request')->request->get('area4_campeonatobundle_partidotype[resultadov]',null,true);
            
            $entity->setResultadov(intval($resv));
            $entity->setResultadol(intval($resl));
            
            //$em->persist($arbitro);
            $em->persist($entity);
            $em->flush();

            return new Response('Actualizado',200);
        }
        return $this->redirect($this->generateUrl('partido_edit', array('id' => $entity->getId())));
    }

    /**
     * Deletes a Partido entity.
     *
     * @Route("/{id}/delete", name="partido_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('Area4CampeonatoBundle:Partido')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Partido entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('partido'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Listar los jugadores de los Equipos cargados en los partidos
     * @Route("/listaJugadorEquipo/{id}/{id_equipo}", name="lista_jugador_equipo", defaults={"id_equipo"=null})
     * @Template("")
     * @param integer $id : Id del partido.
     * @param integer $id_equipo : es local o visitante el equipo.
     */
    public function listaJugadorEquipoAction($id, $id_equipo){
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Area4CampeonatoBundle:Partido')->find($id);

        if (!$entity) throw $this->createNotFoundException('No se encontro el partido buscado.');   

        $jugadores = $em->getRepository('Area4CampeonatoBundle:Jugador')->equipoPartido($entity,$id_equipo);

        return array(
            'jugadores' => $jugadores,
            'id' => $id,
            'id_equipo' => $id_equipo,
        );
    }

    /**
     * Listar los jugadores de los Equipos cargados en los partidos
     * @Route("/agregarJugadorPartido/{id}/{id_equipo}", name="agregar_jugador_partido")
     * @Template("")
     * @param integer $id : Id del partido.
     * @param integer $id_equipo : Id del Equipo (Utilizado para AJAX)
     */
    public function agregarJugadorPartidoAction($id, $id_equipo=null){
        $jugador = new \Area4\CampeonatoBundle\Entity\Jugador();
        $form   = $this->createForm(new \Area4\CampeonatoBundle\Form\JugadorType(), $jugador);

        $request = $this->getRequest();

        $form->bindRequest($request); // Tengo los datos del form
        if ($request->getMethod() == 'POST'){
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('Area4CampeonatoBundle:Partido')->find($id);
            $jug = $em->getRepository('Area4CampeonatoBundle:Jugador')->findByDni($jugador->getDni());
            
            if (!$entity || !$jug) throw $this->createNotFoundException('Unable to find Partido o Jugador entity.');
            
            //Falta agregar comprovación por categoría.
            $entity->addJugador(end($jug));
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('lista_jugador_equipo', array('id' => $id,
            'id_equipo' => $id_equipo,)));
        }
        //$this->redirect($this->generateUrl('partido'));
        return array( 
            'form' => $form->createView(), 
            'id' => $id,
            'id_equipo' => $id_equipo,
            );
    }

    /**
     * Displays a form to edit an existing Partido entity.
     *
     * @Route("/{id}/edicion", name="edicion_partido")
     * @Template()
     */
    public function edicionAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Partido')->find($id);

        if (!$entity) throw $this->createNotFoundException('No se pudo encontrar el partido buscado.');

        //$editForm = $this->createForm(new PartidoEditType(), $entity);
        //$deleteForm = $this->createDeleteForm($id);

        /*$jugLocales = $em->getRepository('Area4CampeonatoBundle:Jugador')->filtro(
                0, $entity->getLocal()->getId(), $entity->getCategoria()->getId(), $entity->getBloqueLocal(), $entity->getColorLocal()
            );
        $jugVisitantes = $em->getRepository('Area4CampeonatoBundle:Jugador')->filtro(
                0, $entity->getVisitante()->getId(), $entity->getCategoria()->getId(), $entity->getBloqueVisitante(), $entity->getColorVisitante()
            );*/

        $jugLocales = $em->getRepository('Area4CampeonatoBundle:Jugador')->filtro(
                0, $entity->getLocal()->getId(), $entity->getCategoria()->getId()
            );
        $jugVisitantes = $em->getRepository('Area4CampeonatoBundle:Jugador')->filtro(
                0, $entity->getVisitante()->getId(), $entity->getCategoria()->getId()
            );


        return array(
            'partido'      => $entity,
            'jugLocales' => $jugLocales,
            'jugVisitantes' => $jugVisitantes,
        );
    }

}
