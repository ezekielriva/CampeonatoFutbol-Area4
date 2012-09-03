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
    public function indexAction($page=1) {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4CampeonatoBundle:Jugador')->findAll();

        /* * * PAGINADOR ** 
        $adapter = new ArrayAdapter($entities);
        $pager = new Pager($adapter, array('page'=>$page, 'limit'=>50) );*/

        return array(
            'entities' => $entities, 
            //'pager' => $pager,
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

        $formJugador = $this->createForm(new JugadorType(), $jugador);
        $formUsuario = $this->container->get('fos_user.registration.form');

        return array(
            'formJugador' => $formJugador->createView(),
            'formUsuario' => $formUsuario->createView(),
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
            $usuario->addRole('ROLE_JUG');
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

        $em = $this->getDoctrine()->getEntityManager();

        $jugador = $em->getRepository('Area4CampeonatoBundle:Jugador')->find($dni);

        if (!$jugador) {
            throw $this->createNotFoundException('No se encontro el Jugador buscado.');
        }

        $usuario = $jugador->getUsuario();
        $userSession = $this->container->get('security.context')->getToken()->getUser();
        if ( !$usuario->equals($userSession) ) {
            throw new AccessDeniedException();
        }


        if ($jugador->getUsuario()->hasRole('ROLE_ORG'))
            $template = 'organizadorPerfil';
        else {
            if ($jugador->getUsuario()->hasRole('ROLE_ORG'))
                $template = 'capitanPerfil';
            else
                $template = 'perfil';
        }
        $template = $template.'.html.twig';
        return $this->render('Area4CampeonatoBundle:Jugador:'.$template, array(
            'jugador' => $jugador,
            ));
    }

    /**
     * Edits an existing Jugador entity.
     *
     * @Route("/{id}/update", name="jugador_update")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Jugador:edit.html.twig")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Jugador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encontro el Jugador buscado.');
        }

        $editForm = $this->createForm(new JugadorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('jugador_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
     *
     * @param date $fecha
     * @return \Area4\CampeonatoBundle\Entity\Categoria
     */
    public function calcularCategoria($fecha) {
        $fecha = \date_format($fecha, 'Y');
        $em = $this->getDoctrine()->getEntityManager();
        $cat = $em->getRepository('Area4CampeonatoBundle:Categoria')->catApropiada($fecha);
        /* @var $cat  \Area4\CampeonatoBundle\Entity\Categoria */
        if (!$cat)
            throw $this->createNotFoundException('Unable to find Categoria entity.' . $fecha);
        return $cat[0];
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
     * @Route("/limpiarDni/", name="limpiarDni")
     * @Template()
     */
    public function limpiarDniAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $jug = new \Doctrine\Common\Collections\ArrayCollection();
        $jug = $em->getRepository('Area4CampeonatoBundle:Jugador')->findAll();
        $count = 0;
        foreach ($jug as $val) {
            if(strpos($val->getDni(), ".")){
                $val->setDni(
                    str_replace('.', '', $val->getDni()) 
                );    
                ++$count;
                echo $val;
                echo '<br/>';
                //
                    $em->persist($val);
            }
            
        }
        echo $count."";
        $em->flush();

        return array();
    }

    /**
     * @Route("/limpiarDni2/", name="limpiarDni2")
     * @Template()
     */
    public function limpiarDni2Action() {
        $em = $this->getDoctrine()->getEntityManager();
        $jug = new \Doctrine\Common\Collections\ArrayCollection();
        $jug = $em->getRepository('Area4CampeonatoBundle:Jugador')->findAll();
        $count = 0;
        foreach ($jug as $val) {
            if(strpos($val->getDni(), " ")){
                $val->setDni(
                    str_replace(" ", "", $val->getDni()) 
                );    
                ++$count;
                
                $j = $em->getRepository('Area4CampeonatoBundle:Jugador')->findOneByDni($val->getDni());
                if(is_null($j)){
                    echo "NO ENCONTRADO: ".$val;
                    echo '<br/>';
                    $em->persist($val);
                }
            }
            
        }
        echo $count."";
        $em->flush();

        return array();
    }


}
