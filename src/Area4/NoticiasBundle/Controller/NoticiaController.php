<?php

namespace Area4\NoticiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\NoticiasBundle\Entity\Noticia;
use Area4\NoticiasBundle\Form\NoticiaType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use MakerLabs\PagerBundle\Adapter\DoctrineOrmAdapter;
use MakerLabs\PagerBundle\Pager;

/**
 * Noticia controller.
 *
 * @Route("/noticia")
 */
class NoticiaController extends Controller {

	/**
	 * Lists all Noticia entities.
	 *
	 * @Route("/{page}", name="noticia",  requirements={"page" = "\d+"}, defaults={"page" = 1})
	 * @Template()
	 */
	public function indexAction($page=0) {

	$em = $this->getDoctrine()->getEntityManager();
		$notR = $em->getRepository('Area4NoticiasBundle:Noticia')->findAll();
		/* @var $notR NoticiaRepository */

		/*		 * * PAGINADOR ** */
		/*$adapter = new DoctrineOrmAdapter($notR->QryLista());
		$pager = new Pager($adapter, array('page' => $page, 'limit' => 5));*/

		return array('entities' => $notR);
	}

	/**
	 * Finds and displays a Noticia entity.
	 *
	 * @Route("/{id}/show", name="noticia_show")
	 * @Template()
	 */
	public function showAction($id) {
		$em = $this->getDoctrine()->getEntityManager();

		$entity = $em->getRepository('Area4NoticiasBundle:Noticia')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Noticia entity.');
		}

		$deleteForm = $this->createDeleteForm($id);

		return array(
				'entity' => $entity,
				'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Realiza un echo del texto de una noticia, se realiza debido al TinyMCE
	 *
	 * @return Response
	 * @author ezekiel
	 **/
	public function mostrarTextoAction($idNoticia)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$entity = $em->getRepository('Area4NoticiasBundle:Noticia')->find($id);

		echo $entity->getTexto();

		return Response();
	}

	/**
	 * Displays a form to create a new Noticia entity.
	 *
	 * @Route("/new", name="noticia_new")
	 * @Template()
	 */
	public function newAction() {
		$entity = new Noticia();
		$form = $this->createForm(new NoticiaType(), $entity);

		return array(
				'entity' => $entity,
				'form' => $form->createView(),
				'edit_form' => $form->createView(),
		);
	}

	/**
	 * Creates a new Noticia entity.
	 *
	 * @Route("/create", name="noticia_create")
	 * @Method("post")
	 * @Template("Area4NoticiasBundle:Noticia:new.html.twig")
	 */
	public function createAction() {
		$entity = new Noticia();
		$request = $this->getRequest();
		$form = $this->createForm(new NoticiaType(), $entity);

		if ('POST' === $request->getMethod()) {
			$form->bindRequest($request);

			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$entity->setPath($this->get('kernel')->getRootDir()."/../web");
				$entity->upload();

				$em->persist($entity);
				$em->flush();

				return $this->redirect($this->generateUrl('noticia'));
			}
		}

		return array(
				'entity' => $entity,
				'form' => $form->createView()
		);
	}

	/**
	 * Displays a form to edit an existing Noticia entity.
	 *
	 * @Route("/{id}/edit", name="noticia_edit")
	 * @Template()
	 */
	public function editAction($id) {
		$em = $this->getDoctrine()->getEntityManager();

		$entity = $em->getRepository('Area4NoticiasBundle:Noticia')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Noticia entity.');
		}

		$editForm = $this->createForm(new NoticiaType(), $entity);
		$deleteForm = $this->createDeleteForm($id);

		return array(
				'entity' => $entity,
				'edit_form' => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Edits an existing Noticia entity.
	 *
	 * @Route("/{id}/update", name="noticia_update")
	 * @Method("post")
	 * @Template("Area4NoticiasBundle:Noticia:edit.html.twig")
	 */
	public function updateAction($id) {
		$em = $this->getDoctrine()->getEntityManager();

		$entity = $em->getRepository('Area4NoticiasBundle:Noticia')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Noticia entity.');
		}

		$editForm = $this->createForm(new NoticiaType(), $entity);
		$deleteForm = $this->createDeleteForm($id);

		$request = $this->getRequest();

		if ('POST' === $request->getMethod()) {
			$editForm->bindRequest($request);

			if ($editForm->isValid()) {
				$entity->setPath($this->get('kernel')->getRootDir()."/../web");
				$entity->upload();

				$em->persist($entity);
				$em->flush();

				return $this->redirect($this->generateUrl('noticia'));
			}
		}

		return array(
				'entity' => $entity,
				'edit_form' => $editForm->createView(),
				'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Deletes a Noticia entity.
	 *
	 * @Route("/{id}/delete", name="noticia_delete")
	 * @ Method("post")
	 */
	public function deleteAction($id) {
//		$form = $this->createDeleteForm($id);
//		$request = $this->getRequest();
//
//		if ('POST' === $request->getMethod()) {
//			$form->bindRequest($request);
//
//			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$entity = $em->getRepository('Area4NoticiasBundle:Noticia')->find($id);

				if (!$entity) {
					throw $this->createNotFoundException('Unable to find Noticia entity.');
				}

				$em->remove($entity);
				$em->flush();
//			}
//		}

		return $this->redirect($this->generateUrl('noticia'));
	}

	private function createDeleteForm($id) {
		return $this->createFormBuilder(array('id' => $id))
						->add('id', 'hidden')
						->getForm()
		;
	}

	/**
	 * @Template("Area4NoticiasBundle:Admin:menu.html.twig")
	 */
	public function adminAction() {
		return array();
	}

}
