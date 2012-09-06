<?php

namespace Area4\ContableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\ContableBundle\Entity\Documento;
use Area4\ContableBundle\Form\DocumentoType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Documento controller.
 *
 * @Route("/documento")
 */
class DocumentoController extends Controller {

	/**
	 * Lists all Documento entities.
	 *
	 * @Route("/", name="documento")
	 * @Template()
	 */
	public function indexAction() {
		return array();
	}
	/**
	 * Lists all Documento entities.
	 *
	 * @Route("/tableIndex", name="documento_table_index")
	 * @Template()
	 */
	public function tableIndexAction() {
		$em = $this->getDoctrine()->getEntityManager();

		$entities = $em->getRepository('Area4ContableBundle:Documento')->findAll();

		return array('entities' => $entities);
	}

	/**
	 * Finds and displays a Documento entity.
	 *
	 * @Route("/{id}/show", name="documento_show")
	 * @Template()
	 */
	public function showAction($id) {
		$em = $this->getDoctrine()->getEntityManager();

		$entity = $em->getRepository('Area4ContableBundle:Documento')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Documento entity.');
		}

		$deleteForm = $this->createDeleteForm($id);

		return array(
				'entity' => $entity,
				'delete_form' => $deleteForm->createView(),);
	}

	/**
	 * Displays a form to create a new Documento entity.
	 *
	 * @Route("/new", name="documento_new")
	 * @Template()
	 */
	public function newAction() {
		$documento = new Documento();
		$em = $this->getDoctrine()->getEntityManager();
		$tipo = $em->getRepository('Area4ContableBundle:Tipo')->findAll();
		if (!$tipo) {
			throw $this->createNotFoundException('No hay Tipos de Documentos creados. Por favor cree uno');
		}
		$form = $this->createForm(new DocumentoType(), $documento);
		return array(
				'entity' => $documento,
				'form' => $form->createView()
		);
	}

	/**
	 * Creates a new Documento entity.
	 *
	 * @Route("/create", name="documento_create")
	 * @Method("post")
	 * @Template("Area4ContableBundle:Documento:new.html.twig")
	 */
	public function createAction() {
		$documento = new Documento();
		$request = $this->getRequest();
		$form = $this->createForm(new DocumentoType(), $documento);
		$form->bindRequest($request); //Tengo los datos del form

		if ($form->isValid()) {
			$documento->setNumeroAuto();
			$tipo = $documento->getTipo();
			$tipo->plusOneToUltimo();
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($documento);
			$em->persist($tipo);
			$em->flush();

			return $this->redirect($this->generateUrl('documento_edit',array('id'=>$documento->getId())));
		}

		return array(
				'entity' => $documento,
				'form' => $form->createView()
		);
	}

	/**
	 * Displays a form to edit an existing Documento entity.
	 *
	 * @Route("/{id}/edit", name="documento_edit")
	 * @Template()
	 */
	public function editAction($id) {
		$em = $this->getDoctrine()->getEntityManager();

		$documento = $em->getRepository('Area4ContableBundle:Documento')->find($id);

		if (!$documento) {
			throw $this->createNotFoundException('Unable to find Documento entity.');
		}

		$editForm = $this->createForm(new DocumentoType(), $documento);
		$deleteForm = $this->createDeleteForm($id);

		return array(
				'entity' => $documento,
				'edit_form' => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Edits an existing Documento entity.
	 *
	 * @Route("/{id}/update", name="documento_update")
	 * @ Method("post")
	 * @Template("Area4ContableBundle:Documento:edit.html.twig")
	 */
	public function updateAction($id) {
		$em = $this->getDoctrine()->getEntityManager();

		$entity = $em->getRepository('Area4ContableBundle:Documento')->find($id);
		$request = $this->getRequest();
		$username = $request->request->get('Cliente');
		$Cliente = $em->getRepository('Area4ContableBundle:Cliente')->buscarPorUsername($username);

		if (!$entity) throw $this->createNotFoundException('No se encontro el Documento buscado.');
		if (!$Cliente) throw $this->createNotFoundException('No se encontro el Cliente buscado.');
		
		$entity->setCliente($Cliente);
		$entity->calcularTotal();
		$em->persist($entity);
		$em->flush();

		return new Response();
	}

	/**
	 * Deletes a Documento entity.
	 *
	 * @Route("/{id}/delete", name="documento_delete")
	 * Method("post")
	 */
	public function deleteAction($id) {
			$em = $this->getDoctrine()->getEntityManager();
			$entity = $em->getRepository('Area4ContableBundle:Documento')->find($id);

			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Documento entity.');
			}
			$em->remove($entity);
			$em->flush();
	

		return $this->redirect($this->generateUrl('documento'));
	}

	private function createDeleteForm($id) {
		return $this->createFormBuilder(array('id' => $id))
										->add('id', 'hidden')
										->getForm()
		;
	}

	/**
	 * Lists all Documento entities.
	 *
	 * @Route("/buscar", name="documento_buscar")
	 * @Template("Area4ContableBundle:Documento:index.html.twig")
	 */
	public function buscarAction() {
		$em = $this->getDoctrine()->getEntityManager();
		$q = $this->getRequest()->get('q');
		$Rq = $em->getRepository('Area4ContableBundle:Documento');
		/* @var $Rq \Area4\ContableBundle\Entity\DocumentoRepository */
		if (trim($q) > "") {
			$entities = $Rq->buscar($q);
		} else {
			$entities = $em->getRepository('Area4ContableBundle:Documento')->findAll();
		}
		return array('entities' => $entities);
	}

}
