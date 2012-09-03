<?php

namespace Area4\NoticiasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MakerLabs\PagerBundle\Adapter\DoctrineOrmAdapter;
use MakerLabs\PagerBundle\Pager;

class DefaultController extends Controller {

	/**
	 * Pagina principal delcanal de noticias
	 * @Route("/")
	 * @Template("Area4NoticiasBundle:Default:index.html.twig")
	 */
	public function indexAction() {
		$page = $this->get('request')->query->get('page', 1);
		return array(
				'page' => $page,
		);
	}

	/**
	 * Declara cuantas noticias debe haber en el bloque central
	 * @Route("/prueba/{cant}")
	 * @Template("Area4NoticiasBundle:Default:centrales.html.twig")
	 */
	public function centralesAction($cant=3) {

		/* @var $em EntityManager */
		$em = $this->getDoctrine()->getEntityManager();

		$rep = $em->getRepository('Area4NoticiasBundle:Noticia');
		/* @var $rep NoticiaRepository */
		$des = $rep->getUltimas(3);
//		$una = $rep->QryLista()
//						->setMaxResults(1)
//						->getQuery()
//						->getResult();
		return array(
				'des' => $des,
				'una' => $des[0],
		);
	}

	/**
	 * @Route("/lista/{page}")
	 * @Template ("Area4NoticiasBundle:Default:lista.html.twig")
	 */
	public function listaAction($page=1) {
		/* @var $em EntityManager */
		$em = $this->getDoctrine()->getEntityManager();
		$notR = $em->getRepository('Area4NoticiasBundle:Noticia');
		/* @var $notR NoticiaRepository */

		$adapter = new DoctrineOrmAdapter($notR->QryLista());
		$pager = new Pager($adapter, array('page' => $page, 'limit' => 8));
		return array(
				'lista' => $pager,
		);
	}

	/**
	 * Pagina principal delcanal de noticias
	 * @Route("/ver/{id}", name="noticia_ver")
	 * @Template("Area4NoticiasBundle:Default:ver.html.twig")
	 */
	public function verAction($id) {
		$em = $this->getDoctrine()->getEntityManager();
		$entity = $em->getRepository('Area4NoticiasBundle:Noticia')->find($id);
		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Noticia entity.');
		}
		return array(
				'not' => $entity,
		);
	}

}

?>