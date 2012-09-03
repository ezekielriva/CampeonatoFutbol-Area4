<?php

namespace Area4\CampeonatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\Notificaciones;
use Area4\CampeonatoBundle\Entity\Campeonato;
use Area4\CampeonatoBundle\Form\NotificacionesType;
use Area4\CampeonatoBundle\Form\NotificarEquipoType;
use Area4\CampeonatoBundle\Form\NotificarJugadorType;
use Symfony\Component\HttpFoundation\Response;
/**
 * Notificaciones controller.
 *
 * @Route("/notificaciones")
 */
class NotificacionesController extends Controller
{
    /**
     * Lists all Notificaciones.
     *
     * @Route("/index/{tipo}", name="notificaciones")
     * @Template()
     */
    public function indexAction($tipo="Base")
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $anon = true;
        $notificaciones = new Notificaciones();
        if($user != 'anon.') {
            $notificaciones = $em->getRepository('Area4CampeonatoBundle:Notificaciones')
                       ->findBy(array('Usuario' => $user->getId(),'enabled'=>Notificaciones::$ENABLED));
            $anon = false;
        }

        return $this->render('Area4CampeonatoBundle:Notificaciones:index'.$tipo.'.html.twig', array('notificaciones' => $notificaciones, 'anon' => $anon));
    }

    /**
     * Finds and displays a Notificaciones entity.
     *
     * @Route("/{id}/show", name="notificaciones_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Notificaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Notificaciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Invitamos a los Capitanes a un torneo
     *
     * @Route("/equipo/create", name="notificaciones_equipo_create")
     * @ Template()
     * @author ezekiel
     **/
    public function notifyCapitanAction()
    {
        $campeonato  = new Campeonato();
        $request = $this->getRequest();
        $form    = $this->createForm(new NotificarEquipoType(), $campeonato);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        foreach ($campeonato->getEquipo() as $equipo) {
            $capitan = $equipo->getCapitan();
        }

        return new Response();
    }

    /**
     * Displays a form to create a new Notificaciones entity.
     *
     * @Route("/new/{idCampeonato}", name="notificaciones_new")
     * @Template()
     */
    public function newAction($idCampeonato)
    {
        $session = $this->getRequest()->getSession();
        $session->set('idCampeonato', $idCampeonato);

        $em = $this->getDoctrine()->getEntityManager();

        $equipos = $em->getRepository('Area4CampeonatoBundle:Equipo')->findAll();

        $form   = $this->createForm(new NotificarEquipoType(), new Campeonato());

        return array(
            'equipos' => $equipos,
            'form' => $form->createView(),
        );
    }

    /**
     * Muestra el form para invitar jugadores a un equipo.
     *
     * @Route("/jugadores/new", name="notificaciones_jugadores_equipo")
     * @Template()
     */
    public function jugadorEquipoAction()
    {
        $notificacion = new Notificaciones();

        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($user->getId());

        $notificacion->setEquipo($jugador->getEquipo());

        return array(
            'notificacion' => $notificacion,
        );
    }


    /**
     * Crea las notificaciones para un Jugador asi este entre a un equipo.
     *
     * @Route("/create/jugadorEquipo", name="notificaciones_create")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Notificaciones:jugadorEquipo.html.twig")
     */
    public function createAction()
    {
        $entity  = new Notificaciones();
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();
        $equipo = $em->getRepository('Area4CampeonatoBundle:Equipo')->findOneById($request->request->get('equipoId'));
        $usernames = explode(',', trim($request->request->get('usernames'),', ') );

        if (!is_null($usernames)) {
            
            foreach ($usernames as $username) {
                $usuario = $em->getRepository('Area4UsuarioBundle:Usuario')->findOneByUsername($username);
                $notificacion = new Notificaciones();
                $notificacion->setUsuario($usuario);
                $notificacion->setEquipo($equipo);
                $tipoNotificacion = $em->getRepository('Area4CampeonatoBundle:TipoNotificacion')->findOneBy(array('short_name'=>$request->request->get('tipo')));
                $notificacion->setTipo($tipoNotificacion);
                $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($usuario->getId());
                $notificacion->setUrl($this->generateUrl('notificaciones_analice', 
                    array('id' => $jugador->getDni(),
                          'idEquipo' => $equipo->getId(),
                          'idCampeonato' => -1
                        ))
                );
                $em->persist($notificacion);
            }
            $em->flush();

            $user = $this->container->get('security.context')->getToken()->getUser();
            $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($user->getId());
            return $this->render('Area4CampeonatoBundle:Notificaciones:create.html.twig', array());
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Notificaciones entity.
     *
     * @Route("/{id}/edit", name="notificaciones_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Notificaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Notificaciones entity.');
        }

        $editForm = $this->createForm(new NotificacionesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Notificaciones entity.
     *
     * @Route("/{id}/update", name="notificaciones_update")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Notificaciones:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Notificaciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Notificaciones entity.');
        }

        $editForm   = $this->createForm(new NotificacionesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('notificaciones_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Notificaciones entity.
     *
     * @Route("/{id}/delete", name="notificaciones_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('Area4CampeonatoBundle:Notificaciones')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Notificaciones entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('notificaciones'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Analisa una notificacion
     * @Route("/analiceNotificacion/{id}/{idEquipo}/{idCampeonato}", name="notificaciones_analice")
     * @Template("Area4CampeonatoBundle:Notificaciones:mensaje.html.twig")
     **/
    public function analiceNotificacionAction($id,$idEquipo=-1, $idCampeonato=-1)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $notificacion = $em->getRepository('Area4CampeonatoBundle:Notificaciones')->find($id);
        // Notificación para jugar en un equipo.
        /*if ( 0 < $idEquipo && 0 > $idCampeonato ){
            $user = $this->container->get('security.context')->getToken()->getUser();
            $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($user->getId());
        }*/
        return array('notificacion'=>$notificacion);
    }

    /**
     * @Route("/mensaje/{id}/", name="notificacion_mensaje_confirmacion")
     * @Template("Area4CampeonatoBundle:Notificaciones:mensaje.html.twig")
     **/
    public function getMensajeAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $notificacion = $em->getRepository('Area4CampeonatoBundle:Notificaciones')->find($id);
        return array('notificacion'=>$notificacion);
    }

    /**
     * @Route("/confirmar/{id}", name="notificacion_confirmar")
     *
     * @return Response
     * @author ezekiel
     **/
    public function confirmarNotificacionAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $notificacion = $em->getRepository('Area4CampeonatoBundle:Notificaciones')->find($id);



        $user = $this->container->get('security.context')->getToken()->getUser();
        $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($user->getId());

        if ($notificacion->getEquipo()) {
            //Si la notificación tiene un equipo la invitación es para un jugador
            $jugador->setEquipo($notificacion->getEquipo());
            $em->persist($jugador);
        }
        if ($notificacion->getCampeonato()) {
            //Si la notificacion tiene un campeonato es para invitar a un equipo
            $equipo = $jugador->getEquipo();
            $equipo->addCampeonato($notificacion->getCampeonato());
            $em->persist($equipo);
        }        
        $notificacion->setEnabled(false);
        $em->persist($notificacion);
        $em->flush();
        return new Response();
    }

    /**
     * Analisa los sucesos correspondientes con el perfil.
     * 1. Tiene o no equipo.
     *
     *  
     **/
    public function perfilAction($dni)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->find($dni);

        if(!$jugador->hasEquipo()){
            if ($jugador->isCapitan()){
                echo "No tiene ningun equipo. Cree uno.";
                echo "<a href=".$this->generateUrl('equipo_new').">Click aqui</a>";
            }
        }
        return new Response();
    }

    /**
     * Pone la notificación como leida
     *
     * @return Response()
     * @author ezekiel
     **/
    public function wasReadAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $notificacion = $em->getRepository('Area4CampeonatoBundle:Notificaciones')->findOneById($id);

        if (!$notificacion)
            throw $this->createNotFoundException('No se encontro la notificación.');

        if ($notificacion->getWasRead() === Notificaciones::UNREAD) {
            $notificacion->setWasRead(Notificaciones::READ);
            $em->persist($notificacion);
            $em->flush();
        }
        return new Response();
    }

    /**
    *
    * @return Response()
    * @author ezekiel
    **/
    public function analiseAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $user = $this->container->get('security.context')->getToken()->getUser();
        $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($user->getId());

        $invitacion = $em->getRepository('Area4CampeonatoBundle:Invitaciones')->findOneByEmail($user->getEmail());
        if ($invitacion){
            if (!$jugador->hasEquipo()) {
                if ($jugador->isCapitan())
                    $notificacion = new Notificaciones();
                    $tipoNotificacion = $em->getRepository('Area4CampeonatoBundle:TipoNotificacion')->findOneBy(array('short_name' => 'NO_TEAM_CAPI'));
                    $notificacion->setTipo($tipoNotificacion);
                    $notificacion->setUsuario($user);
                    $notificacion->setCampeonato($invitacion->getCampeonato());
            }
            $em->remove($invitacion);
            $em->persist($notificacion);
            $em->flush();
        }
        
        


        return new Response();
    }

    /**
     * Envia la notificación a un jugador
     *
     * @return void
     * @author 
     **/
    public function inviteJugadorAction($idEquipo)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $jugadores = $em->getRepository('Area4CampeonatoBundle:Equipo')->buscarSinEquipo();

        return array(
            'equipos' => $equipos,
        );
    }

    /**
     * Genera la notificación para los capitanes
     *
     * @return string
     * @author ezekiel
     **/
    private function generateNotificationCapitan()
    {
        
    }
}
