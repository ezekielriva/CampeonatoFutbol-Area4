<?php

namespace Area4\CampeonatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\Partido;
use Area4\CampeonatoBundle\Entity\Equipo_has_Partido;
use Area4\CampeonatoBundle\Form\PartidoType;
use Area4\CampeonatoBundle\Form\PartidoEditType;
use Area4\CampeonatoBundle\Form\Equipo_has_PartidoType;
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

        $entities = $em->getRepository('Area4CampeonatoBundle:Partido')->findAll();
        //$e_h_p = $em->getRepository('Area4CampeonatoBundle:Equipo_has_Partido')->findAll();

        return array('entities' => $entities);
    }
    /**
     * List por campeonato
     * @Route("/partidoByCampeonato", name="partido_by_campeonato")
     * @Template("Area4CampeonatoBundle:Partido:index.html.twig")
     * @return Partidos
     * @author ezekiel
     **/
    public function listByCampeonatoAction()
    {
        $request = $this->get('request');
        $campeonato = $request->request->get('campeonato');

        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4CampeonatoBundle:Partido')->findByCampeonato($campeonato);


        return array('entities' => $entities, 'campeonato' => $campeonato);
    }

    

    /**
     * Displays a form to create a new Partido entity.
     *
     * @Route("/new/", name="partido_new")
     * @Template()
     */
    public function newAction()
    {
        $request = $this->get('request');
        $campeonatoId = $request->request->get('campeonato');
        /* Precondicion: debe haber al menos 2 equipos inscriptos en el Campeonato */
        $em = $this->getDoctrine()->getEntityManager();
        $campeonato = $em->getRepository('Area4CampeonatoBundle:Campeonato')->findOneById($campeonatoId);
        if ( count($campeonato->getEquipo()) > 2 ){
            $partido = new Partido();
        
            $campeonato = $em->getRepository('Area4CampeonatoBundle:Campeonato')->findOneById($campeonatoId);

            $partidoType = new PartidoType();
            $partidoType->setCampeonato($campeonato);

            $form = $this->createForm($partidoType, $partido);

            return array(
                'entity' => $partido,
                'form'   => $form->createView(),
            );
        }

        echo "<h2>Debe de haber al menos 2 equipos en el Campeonato</h2>";
        //throw $this->createNotFoundException('Debe de haber al menos 2 equipos en el Campeonato');
        return new Response();
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

        $request = $this->getRequest();
        $campeonatoId = $request->request->get('campeonato');

        $editType = new PartidoEditType();
        $campeonato = $em->getRepository('Area4CampeonatoBundle:Campeonato')->find($campeonatoId);
        $editType->setCampeonato($campeonato);

        $editForm = $this->createForm($editType, $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
        if (!$entity) throw $this->createNotFoundException('No se encontro el Partido buscado.');

        $editType = new PartidoEditType();
        $editType->setCampeonato($entity->getCampeonato());
        $form   = $this->createForm($editType, $entity);
        $request = $this->getRequest();
    
        $form->bindRequest($request); //Tengo los datos
        if ($request->getMethod() == 'POST') {
                   
            //$em->persist($arbitro);
            $em->persist($entity);
            $em->flush();

            return new Response(
                sprintf('<script type="text/javascript">gestionPartidos(%s)</script>',$entity->getCampeonato()->getId()),
                200
                );
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
     * Muestra la planilla de los partidos
     * @Route("/{id}/planilla", name="partido_planilla")
     * @Template()
     * @return void
     * @author 
     **/
    public function planillaAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $partido = $em->getRepository('Area4CampeonatoBundle:Partido')->find($id);

        if (!$partido) {
            throw $this->createNotFoundException('Unable to find Partido entity.');
        }

        return array(
            'partido'      => $partido,
            );
    }
}
