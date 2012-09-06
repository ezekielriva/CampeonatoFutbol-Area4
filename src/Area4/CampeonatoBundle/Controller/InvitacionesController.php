<?php

namespace Area4\CampeonatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\Invitaciones;
use Area4\CampeonatoBundle\Form\InvitacionesType;
use Area4\CampeonatoBundle\Form\InvitacionesCapitanType;
use Area4\CampeonatoBundle\Form\InvitacionesJugadorType;
use Symfony\Component\HttpFoundation\Response;
use Area4\CampeonatoBundle\Entity\Inscripciones;
use Area4\CampeonatoBundle\Entity\Notificaciones;
/**
 * Invitaciones controller.
 *
 * @Route("/invitaciones")
 */
class InvitacionesController extends Controller
{
    /**
     * Analisa los tokens
     * @Route("/{token}/get", name="analise_token")
     * @ Template("")
     **/
    public function analiseTokenAction($token)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $invitacion = $em->getRepository('Area4CampeonatoBundle:Invitaciones')->findOneByToken($token);

        if (!$invitacion){
            throw $this->createNotFoundException('No se encontro el token. Debe tener una invitación');
        }
        
        $usuario = $em->getRepository('Area4UsuarioBundle:Usuario')->findOneByEmail($invitacion->getEmail());
        
        if (!$usuario) {
          return $this->redirect($this->generateUrl('jugador_new',array('token'=>$token)));
        } else {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }

    /**
     * Displays a form to create a new Invitaciones entity.
     *
     * @Route("/new", name="invitaciones_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Invitaciones();
        $form   = $this->createForm(new InvitacionesType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/create", name="invitaciones_create")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Invitaciones:new.html.twig")
     */
    public function createAction()
    {
      $invitacion = new Invitaciones();
      $request = $this->getRequest();
      $form = $this->createForm(new InvitacionesType(), $invitacion);
      $form->bindRequest($request);

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $emailsTrim = trim($invitacion->getEmail(),', ');
        $emails = explode(",", $emailsTrim);
        $invitacionesToSend = array();
        $emailsNoNotify = array();
        $tokens = array();

        $rol = $request->request->get('rol');

        foreach ($emails as $email) {
          $usuario = $em->getRepository('Area4UsuarioBundle:Usuario')->findOneByEmail($email);
          if (!$usuario) {
            $invitacion = new Invitaciones();
            $invitacion->setEmail($email);
            $invitacion->setTipo($rol);
            $invitacionesToSend[] = $invitacion;
            $em->persist($invitacion);
          }
          else {
            $emailsNoNotify[] = $email;
          }
        }
        $em->flush();
        $this->sendEmail($invitacionesToSend,'general');
        
        return $this->render('Area4CampeonatoBundle:Invitaciones:created.html.twig', 
          array(
            'invitacionesToSend' => $invitacionesToSend,
            'emailsNoNotify' => $emailsNoNotify,
            ));
      }

      return array(
            'entity' => $invitacion,
            'form'   => $form->createView()
        );
    }

    /**
     * Envia los emails a los pasados por parametros
     *
     * @param $invitaciones array de Invitaciones : emails a enviar las invitaciones.
     * @param $tipo string : tipo de mensaje a enviar.
     *
     * @author ezekiel
     **/
    private function sendEmail($invitaciones,$tipo)
    {
      $request = $request = $this->getRequest();
      $host = $request->headers->get('host');
      $template = $tipo.'.txt.twig';
      foreach ($invitaciones as $invitacion) {
      $message = \Swift_Message::newInstance()
                                ->setSubject('Not Reply: I y C')
                                ->setFrom('invitaciones@iyc.com.ar')
                                ->setTo($invitacion->getEmail())
                                ->setBody($this->renderView('Area4CampeonatoBundle:Invitaciones:'.$template, 
                                  array('token' => $invitacion->getToken(), 'host' => $host,
                                    )))
                                ;
        $this->get('mailer')->send($message);
      }
    }

    /**
     * Crea una notificación para los usuarios que ya se encuentran creados
     *
     * @param email : email a notificar.
     * @param em : entity manager
     * @param tipo : ROL para realizar la notificación
     * @param campeonato : el campeonato al que le corresponde la notificación
     * @author Ezekiel
     **/
    private function crearNotificacion($email, $tipo, $campeonato=null, $equipo=null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $usuario = $em->getRepository('Area4UsuarioBundle:Usuario')->findOneByEmail($email);

        if (!$usuario) {
            return false;
        }
        else {
            $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($usuario->getId());
            if($tipo==='ROLE_CAP') {
              //Precondicion: El Capitan no puede ser invitado 2 veces al mismo Campeonato - start
              $equipo = $jugador->getEquipo();
              if ($equipo->juegaInCameponato($campeonato))
                return false;
              //endPrecondicion
              $tipoNotificacion = $em->getRepository('Area4CampeonatoBundle:TipoNotificacion')->findOneByShortName('INVITE_TEAM');
              $notificacion = new Notificaciones();
              $notificacion->setTipo($tipoNotificacion);
              $notificacion->setCampeonato($campeonato);
            }
            else {
                $tipoNotificacion = $em->getRepository('Area4CampeonatoBundle:TipoNotificacion')->findOneByShortName('INVITE_PLAY');
                $notificacion = new Notificaciones();
                $notificacion->setTipo($tipoNotificacion);
                $notificacion->setEquipo($equipo);
            }
            $notificacion->setUsuario($usuario);
            $em->persist($notificacion);
            $em->flush();
            return true;
        }
    }

    /**
     * Invitaciones a los capitanes
     *
     * @Route("/equipos/{idCampeonato}", name="invitaciones_capitan")
     * @ Method("post")
     * @Template()
     **/
    public function invitarCapitanesAction($idCampeonato=0)
    {
        /** Verificamos si hay alguna inscripcion abierta **/
        $em = $this->getDoctrine()->getEntityManager();
        $inscripcion = new Inscripciones();

        //Precondición: Las inscripciones de Equipos deben estar abiertas - start
        $fecha = new \DateTime('now');
        $inscripcion = $em->getRepository('Area4CampeonatoBundle:Inscripciones')
                          ->hayInscripcionesAbiertas(date_format($fecha, 'Y-m-d'), 'ROLE_CAP', $idCampeonato);

        
        if(!$inscripcion){
            throw $this->createNotFoundException('No hay inscripciones abiertas');
        }
        //endPrecondición
        
        $invitacionCapitan = new Invitaciones();
        $invitacionCapitan->setTipo('ROLE_CAP');
        //$invitacionCapitan->setCampeonato($idCampeonato);

        $form = $this->createForm(new InvitacionesCapitanType(), $invitacionCapitan);

        return array(
            'invitacion' => $invitacionCapitan,
            'form'   => $form->createView()
        );
    }

    /**
     * Invitaciones a los jugadores
     *
     * @Route("/jugadores/{idEquipo}", name="invitaciones_jugadores")
     * @ Method("post")
     * @Template()
     **/
    public function invitarJugadoresAction($idEquipo)
    {
        /** Verificamos si hay alguna inscripcion abierta **/
        $em = $this->getDoctrine()->getEntityManager();
        /*$inscripcion = new Inscripciones();
        $fecha = new \DateTime('now');
        $inscripcion = $em->getRepository('Area4CampeonatoBundle:Inscripciones')
                          ->hayInscripcionesAbiertas(date_format($fecha, 'Y-m-d'), 'ROLE_JUG', $idCampeonato);

        if(!$inscripcion){
            throw $this->createNotFoundException('No hay inscripciones abiertas');
        }*/

        $invitacionJugadores = new Invitaciones();
        $invitacionJugadores->setTipo('ROLE_JUG');
        $equipo = $em->getRepository('Area4CampeonatoBundle:Equipo')->findOneById($idEquipo);
        $invitacionJugadores->setEquipo($equipo);

        $form = $this->createForm(new InvitacionesJugadorType(), $invitacionJugadores);

        return array(
            'invitacion' => $invitacionJugadores,
            'form'   => $form->createView()
        );
    }
}
