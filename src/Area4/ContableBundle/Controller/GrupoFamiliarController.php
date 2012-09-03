<?php

namespace Area4\ContableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\ContableBundle\Entity\GrupoFamiliar;
use Area4\ContableBundle\Form\GrupoFamiliarType;

/**
 * GrupoFamiliar controller.
 *
 * @Route("/grupofamiliar")
 */
class GrupoFamiliarController extends Controller
{
    /**
     * Lists all GrupoFamiliar entities.
     *
     * @Route("/", name="grupofamiliar")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4ContableBundle:GrupoFamiliar')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a GrupoFamiliar entity.
     *
     * @Route("/{id}/show", name="grupofamiliar_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:GrupoFamiliar')->find($id);

        if (!$entity) throw $this->createNotFoundException('No se encontro el grupo familiar');

        $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findByGrupoFamiliar($entity->getId());
        
        return array(
            'entity' => $entity,
            'jugadores' => $jugador,
            );
    }

    /**
     * Displays a form to create a new GrupoFamiliar entity.
     *
     * @Route("/new", name="grupofamiliar_new")
     * @Template()
     */
    public function newAction()
    {
        /*
            Cargamos el DNI del responsable.
        */
        $entity = new GrupoFamiliar();
        $form   = $this->createForm(new GrupoFamiliarType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new GrupoFamiliar entity.
     *
     * @Route("/create", name="grupofamiliar_create")
     * @Method("post")
     * @Template("Area4ContableBundle:GrupoFamiliar:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new GrupoFamiliar();
        $request = $this->getRequest();
        $form    = $this->createForm(new GrupoFamiliarType(), $entity);
        $form->bindRequest($request);        

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByDni($entity->getDni());
            if(!$jugador) throw $this->createNotFoundException('No hay un jugador asosiado a ese DNI. DNI: '.$entity->getDni());

            $entity->setApellido($jugador->getApellido());
            $jugador->setGrupoFamiliar($entity);

            $em->persist($entity);
            $em->persist($jugador);
            $em->flush();

            return $this->redirect($this->generateUrl('grupofamiliar_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing GrupoFamiliar entity.
     *
     * @Route("/{id}/edit", name="grupofamiliar_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:GrupoFamiliar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GrupoFamiliar entity.');
        }

        $editForm = $this->createForm(new GrupoFamiliarType(), $entity);
       

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            
        );
    }

    /**
     * Edits an existing GrupoFamiliar entity.
     *
     * @Route("/{id}/update", name="grupofamiliar_update")
     * @Method("post")
     * @Template("Area4ContableBundle:GrupoFamiliar:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4ContableBundle:GrupoFamiliar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GrupoFamiliar entity.');
        }

        $editForm   = $this->createForm(new GrupoFamiliarType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('grupofamiliar_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a GrupoFamiliar entity.
     *
     * @Route("/delete/{id}", name="grupofamiliar_delete")
     * @ Method("post")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Area4ContableBundle:GrupoFamiliar')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GrupoFamiliar entity.');
        }
        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('grupofamiliar'));
    }

    /**
     * Lists all Jugadores en grupos familiares.
     *
     * @Route("/BuscarGrupoFamiliar", name="BuscarGrupoFamiliar")
     * @Template()
     */
    public function BuscarGrupoFamiliarAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $grupoFamiliar = $em->getRepository('Area4ContableBundle:GrupoFamiliar')->findAll();
        /* @var $grupoFamiliar GrupoFamiliar */
        return array('entities' => $grupoFamiliar);
    }

    /**
     * Genera el cuadro dialog de la busqueda en el dialog
     * @route("/BuscarGrupoFamiliar2/{texto}", name="BuscarGrupoFamiliar2")
     * @Template()
     * @param pagina la cualrenderizar si es correcto
     */
    public function BuscarGrupoFamiliar2Action($texto) {
        /* @var $em EntityManager */
        $em = $this->getDoctrine()->getEntityManager();
        $UR = $em->getRepository('Area4CampeonatoBundle:Jugador');
        $lista = $em->getRepository('Area4ContableBundle:GrupoFamiliar')->findAll();
        /* @var $UR \Area4\ContableBundle\Entity\ClienteRepository */
        $session = $this->get("session");
        /* @var $session \Symfony\Component\HttpFoundation\Session */
        $item_id = $session->get('modItem_id');
        return array(
            'lista' => $lista,
            'item_id' => $item_id,
        );
    }

    /**
    *@route("/addJugador/{id}", name="grupofamiliar_addJugador")
    *@Template()
    */
    public function addJugadorAction($id){
        $entity = new GrupoFamiliar();
        $entity->setId($id);
        $form = $this->createForm(new GrupoFamiliarType(), $entity);
        $request = $this->getRequest();

        $form->bindRequest($request);
        if($request->getMethod() == 'POST'){
            $em = $this->getDoctrine()->getEntityManager();
            $grupofamiliar = $em->getRepository('Area4ContableBundle:GrupoFamiliar')->find($id);
            if (!$grupofamiliar) throw $this->createNotFoundException('No se encontro el grupo familiar.');
            $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByDni($entity->getDni());
            if(!$jugador) throw $this->createNotFoundException('No hay un jugador asociado a ese DNI. DNI: '.$entity->getDni());
            $j = new \Area4\CampeonatoBundle\Entity\Jugador();
            $j = $jugador;
            
            $jugador->setGrupoFamiliar($grupofamiliar);
            $em->persist($jugador);
            $em->flush();
            return $this->redirect($this->generateUrl('grupofamiliar_listarJugador',array('id' => $grupofamiliar->getId())));
        }

        return array(
            'form' => $form->createView(),
            'entity' => $entity,
            );
    }

    /**
    *@route("/listarJugador/{id}", name="grupofamiliar_listarJugador")
    *@Template()
    */
    public function listarJugadoresAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findByGrupoFamiliar($id);
        return array('jugadores' => $jugador);
    }
    /**
    *@route("/removeJugador/{id}", name="grupofamiliar_removeJugador")
    *@Template()
    */
    public function removeJugadorAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->find(intval($id));
        $jugador->setGrupoFamiliar(new GrupoFamiliar());
        $em->persist($jugador);
        $em->flush($jugador);
        return $this->redirect($this->generateUrl('grupofamiliar_listarJugador',array('id' => $grupofamiliar->getId())));
    }
}
