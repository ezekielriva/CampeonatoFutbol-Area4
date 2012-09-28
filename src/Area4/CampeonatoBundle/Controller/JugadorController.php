<?php

namespace Area4\CampeonatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\Jugador;
use Quark\Bundle\ErrorHandlerBundle\Entity\ErrorHandler;
use Area4\CampeonatoBundle\Form\JugadorType;
use Area4\CampeonatoBundle\Form\FiltroType;
use MakerLabs\PagerBundle\Pager;
use MakerLabs\PagerBundle\Adapter\ArrayAdapter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Area4\UsuarioBundle\Entity\Usuario;
use Area4\ContableBundle\Entity\Cliente;
use Area4\UsuarioBundle\Form\UsuarioType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Jugador controller.
 *
 * @Route("/jugador")
 */
class JugadorController extends Controller {

    /**
     * Lists all Jugador entities.
     * @Route("/{page}",requirements={ "page" = "\d+" },defaults={"page"=1}, name="jugador")
     * @Template()
     */
    public function indexAction($page) {
        $em = $this->getDoctrine()->getEntityManager();

        $user = $this->container->get('security.context')->getToken()->getUser();
        $idOrganizador = $user->getId();
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
           $entities = $em->getRepository('Area4CampeonatoBundle:Jugador')->findAll();
        } else {
           $entities = $em->getRepository('Area4CampeonatoBundle:Jugador')->buscarPorOrganizador($idOrganizador);
        }

        /* * * PAGINADOR ** 
        $adapter = new ArrayAdapter($entities);
        $pager = new Pager($adapter, array('page'=>$page, 'limit'=>50) );*/

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $entities, 
                $page,
                //$this->get('request')->query->get('page', 1)/*page number*/,
                3/*limit per page*/
            );

        return array( 
            'pagination' => $pagination,
            //'form' => $form->createView(),
            //'total'=>count($entities),
            );
    }

    /**
     * Finds and displays a Jugador entity.
     *
     * @Route("/{id}/show", name="jugador_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Jugador')->find($id);
        
        /* @var $entity Jugador */
        if (!$entity) {
            throw $this->createNotFoundException('No se encontro el Jugador buscado.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Finds and displays a Jugador entity.
     * @Template("Area4CampeonatoBundle:Jugador:show.html.twig")
     */
    public function showByUserAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encontro el Jugador buscado.');
        }
        return array(
            'entity' => $entity,
            //'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Jugador entity.
     *
     * @Route("/inscribirse", name="jugador_new")
     * @Template()
     */
    public function registerJugadorAction() {
        $jugador = new Jugador();
        $usuario = new Usuario();

        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        $token = $request->query->get('token');
        $invitacion = $em->getRepository('Area4CampeonatoBundle:Invitaciones')->findOneByToken($token);
        $usuario->setEmail($invitacion->getEmail());
        $formJugador = $this->createForm(new JugadorType(), $jugador);
        $formUsuario = $this->container->get('fos_user.registration.form');

        return array(
            'formJugador' => $formJugador->createView(),
            'formUsuario' => $formUsuario->createView(),
            'rol' => $invitacion->getTipo(),
        );
    }

    /**
     * Displays a form to create a new Jugador entity.
     *
     * @Route("/edit", name="jugador_edit")
     * @Template()
     */
    public function editAction() {
        $request = $this->getRequest();
        $idJugador = $request->request->get('idJugador');

        $em = $this->getDoctrine()->getEntityManager();

        $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->find($idJugador);
        $cliente = $em->getRepository('Area4ContableBundle:Cliente')->findOneByReferencia($idJugador);

        $formJugador = $this->createForm(new JugadorType(), $jugador);
        $formUsuario = $this->container->get('fos_user.registration.form');
        $formUsuario->setData($jugador->getUsuario());

        return array(
            'formJugador' => $formJugador->createView(),
            'formUsuario' => $formUsuario->createView(),
            'rol' => $jugador->getUsuario()->getLastRole(),
            'domicilio' => $cliente->getDomicilio(),
        );
    }

    /**
     * Creates a new Jugador entity.
     *
     * @Route("/crear", name="jugador_create")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Jugador:registerJugador.html.twig")
     */
    public function createAction() {
        $jugador = new Jugador();
        $usuario = new Usuario();

        $request = $this->getRequest();
        $formJugador = $this->createForm(new JugadorType(), $jugador);
        $formUsuario = $this->container->get('fos_user.registration.form');
        
        $formJugador->bindRequest($request);
        /** Propio del FOSUsrBundle **/
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $process = $formHandler->process(false);
        $usuario = $formUsuario->getData();
        
        $usuario->setUsername($jugador->getApellido()."-".$jugador->getNombre());
        $usuario->setUsernameCanonical($jugador->getApellido()."-".$jugador->getNombre());

        if($request->getMethod() === 'POST'){
            //Entregando los roles
            $session = $this->getRequest()->getSession();
            $usuario->addRole($request->request->get('rol'));
            $usuario->setEnabled(true);

            $jugador->setUsuario($usuario);
            $cliente = new Cliente();
            $cliente->setDomicilio($request->request->get('domicilio'));
            $cliente->setReferencia($jugador);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($usuario);
            $em->persist($jugador);
            $em->persist($cliente);
            $em->flush();
            $url = $this->container->get('router')->generate('fos_user_registration_confirmed');
            return new RedirectResponse($url);
        }

        return array(
            'formJugador' => $formJugador->createView(),
            'formUsuario' => $formUsuario->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Jugador entity.
     *
     * @Route("/perfil/{dni}", name="jugador_perfil")
     * @Template()
     * @Secure(roles="ROLE_JUG")
     */
    public function perfilAction($dni) {

        $userSession = $this->container->get('security.context')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getEntityManager();

        $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->find($dni);

        if (!$jugador) {
            $jugador = new Jugador();
            $jugador->setUsuario($userSession);
            //throw $this->createNotFoundException('No se encontro el Jugador buscado.');
        }

        $usuario = $jugador->getUsuario();
        
        if ( !$usuario->equals($userSession) ) {
            throw new AccessDeniedException();
        }
        
        return $this->render('Area4CampeonatoBundle:Jugador:perfil.html.twig', array(
            'jugador' => $jugador,
            ));
    }

    /**
     * Edits an existing Jugador entity.
     *
     * @Route("/update", name="jugador_update")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Jugador:editJugador.html.twig")
     */
    public function updateAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        

        $jugadroNew = new Jugador();
        $formJugador = $this->createForm(new JugadorType(), $jugadroNew);
        $formJugador->bindRequest($request);

        $jugadorActual = $em->getRepository('Area4CampeonatoBundle:Jugador')->find($jugadroNew->getDni());
        $formJugador = $this->createForm(new JugadorType(), $jugadorActual);
        $formJugador->bindRequest($request);

        if (!$jugadorActual) {
            throw $this->createNotFoundException('No se encontro el Jugador buscado.');
        }      

        if ($formJugador->isValid()) {
            $cliente = $em->getRepository('Area4ContableBundle:Cliente')->findOneByReferencia($jugadorActual->getDni());
            $cliente->setDomicilio($request->request->get('domicilio'));
            $em->persist($jugadorActual);
            $em->persist($cliente);
            $em->flush();
            return new Response('Se guardaron las modificaciones',200);
        }

        return array(
            'entity' => $jugadroNew,
            'formJugador' => $formJugador->createView(),
            'domicilio' => $request->request->get('domicilio'),
        );
    }

    /**
     * Deletes a Jugador entity.
     *
     * @Route("/{id}/delete", name="jugador_delete")
     * @ Method("post")
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Area4CampeonatoBundle:Jugador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encontro el Jugador buscado.');
        }

        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('jugador'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                ->add('id', 'hidden')
                ->getForm()
        ;
    }

    /**
     * Filtra los datos.
     * 
     * @Route("/filtro/{page}",defaults={"page"=1} , name="filtro")
     * @Template("Area4CampeonatoBundle:Jugador:index.html.twig")
     * @Method("post")
     */
    public function filtroAction($page=1) {
        $jugador = new Jugador();
        $request = $this->getRequest();

        $form = $this->createForm(new FiltroType(), $jugador);
        $form->bindRequest($request); //Tengo los datos
        $em = $this->getDoctrine()->getEntityManager();
        
        

        $jug = $em->getRepository('Area4CampeonatoBundle:Jugador')->filtro(
                        $jugador->getSexo(), 
                        $jugador->getEquipo()->last()->getId(), 
                        $jugador->getCategoria()->last()->getId()
        );

        /* * * PAGINADOR ** */
        $adapter = new ArrayAdapter($jug);
        $pager = new Pager($adapter, array('page'=>$page, 'limit'=>50) );

        return array(
            'entities' => $jug, 
            'pager' => $pager,
            'form' => $form->createView(), 
            'total'=>count($jug)
            );
    }

    /**
     * Carga el lateral del perfil
     * @Route("/jugador_perfil_sidebar", name="jugador_perfil_sidebar")
     * @Template()
     * @return Response
     * @author ezekiel
     **/
    public function sidebarPerfilAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getEntityManager();
        $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByUsuario($user->getId());

        if (!$jugador) {
            $jugador = new Jugador();
            $jugador->setUsuario($user);
        }

        return array('jugador' => $jugador, 'isJugador' => ($user->hasRole('ROLE_ORG')) ? true : false, );
    }

}
