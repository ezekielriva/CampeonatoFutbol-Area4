<?php

namespace Area4\CampeonatoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\CampeonatoBundle\Entity\Campeonato;
use Area4\CampeonatoBundle\Entity\Partido;
use Area4\CampeonatoBundle\Entity\Equipo_has_Partido;
use Area4\CampeonatoBundle\Form\CampeonatoType;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * Campeonato controller.
 *
 * @Route("/campeonato")
 */
class CampeonatoController extends Controller
{
    /**
     * Lists all Campeonato entities.
     *
     * @Route("/", name="campeonato")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('Area4CampeonatoBundle:Campeonato')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Lista de Campeonatos por usuario logueado
     * @Route("/byUsuario", name="campeonato_by_user")
     * @Template("Area4CampeonatoBundle:Campeonato:index.html.twig")
     * @author ezekiel
     **/
    public function indexByUser()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $user = $this->container->get('security.context')->getToken()->getUser(); 
        $entities = $em->getRepository('Area4CampeonatoBundle:Campeonato')->findByUsuario($user->getId());

        return array('entities' => $entities);
    }

    /**
     * Lista todos los campeonato
     *
     * @Route("/list", name="campeonato_list")
     * @Template()
     * @return void
     * @author 
     **/
    public function listAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $user = $this->container->get('security.context')->getToken()->getUser(); 
        $entities = $em->getRepository('Area4CampeonatoBundle:Campeonato')->findByUsuario($user->getId());

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Campeonato entity.
     *
     * @Route("/{id}/show", name="campeonato_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Area4CampeonatoBundle:Campeonato')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campeonato entity.');
        }
        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to create a new Campeonato entity.
     *
     * @Route("/nuevo", name="campeonato_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Campeonato();
        $form   = $this->createForm(new CampeonatoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Campeonato entity.
     *
     * @Route("/create", name="campeonato_create")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Campeonato:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Campeonato();
        $request = $this->getRequest();
        $form    = $this->createForm(new CampeonatoType(), $entity);
        $form->bindRequest($request);

        $user = $this->container->get('security.context')->getToken()->getUser();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity->setUsuario($user);
            $em->persist($entity);
            $em->flush();
            return new Response('Se ha creado el Campeonato',200);
        }
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Campeonato entity.
     *
     * @Route("/{id}/edit", name="campeonato_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Campeonato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campeonato entity.');
        }

        $editForm = $this->createForm(new CampeonatoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Campeonato entity.
     *
     * @Route("/{id}/update", name="campeonato_update")
     * @Method("post")
     * @Template("Area4CampeonatoBundle:Campeonato:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('Area4CampeonatoBundle:Campeonato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campeonato entity.');
        }

        $editForm   = $this->createForm(new CampeonatoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('campeonato_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Campeonato entity.
     *
     * @Route("/{id}/delete", name="campeonato_delete")
     * @ Method("post")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('Area4CampeonatoBundle:Campeonato')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campeonato entity.');
        }

        $em->remove($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('campeonato'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Genera todos los partidos para una liga
     *
     * @return Response
     * @author ezekiel
     * @Route("/generateMatchForLeague/{idCampeonato}", name="campeonato_generateMatchForLeague")
     **/
    public function generateMatchForLeagueAction($idCampeonato)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $campeonato = $em->getRepository('Area4CampeonatoBundle:Campeonato')->findOneById($idCampeonato);
        if (!$campeonato)
            throw $this->createNotFoundException('Unable to find Campeonato entity.');
        $equipos = $campeonato->getEquipo();
        $partidos = array();

        
        foreach($equipos as $x){
            foreach($equipos as $y){
                if($x == $y){
                    continue;
                }
                $partido = new Partido();
                $partido->setLocal($x);
                $partido->setVisitante($y);
                $partido->setCampeonato($campeonato);
                $partidos[] = $partido;
            }
        }

        $fecha = 1;
        foreach ($partidos as $partido) {
            foreach ($partidos as $otro) {
                if ( $partido === $otro ) {
                    $partido->setFecha($fecha);
                }
                if ( $partido->getLocal() != $otro->getLocal() && 
                    $partido->getVisitante() != $otro->getVisitante() && 
                    $partido->getLocal() != $otro->getVisitante() && 
                    $partido->getVisitante() != $otro->getLocal() ) {

                    $partido->setFecha($fecha);
                }
                    
            }
            $fecha++;
        }

        foreach ($partidos as $x) {
            $em->persist($x);
        }
        $em->flush();
        
        return new Response('<h2>Se crearon correctamente los partidos</h2>',200);
    }

    
}