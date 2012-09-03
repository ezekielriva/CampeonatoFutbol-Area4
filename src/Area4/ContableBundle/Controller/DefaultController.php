<?php

namespace Area4\ContableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\ContableBundle\Form\Items2Type;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller {

	/**
	* @route("/cuotas", name="cuotas")
	* @Template("Area4ContableBundle:Default:menu.html.twig")
	*/
	public function cuotasAction(){
		return array();
	}
	/**
	 *
	 * @route("/agregarCarrito/{id}", name="Area4ContableBundle_AgregarCarrito")
	 * @Template("Area4ContableBundle:Documento:show.html.twig")
	 * @param $id El Items->id -> para generar el documento y la cantidad
	 */
	public function AgregarCarritoAction($id) {
		$sf2user = $this->get('security.context')->getToken()->getUser();
		/* @var $sf2user \Area4\UsuarioBundle\Entity\Usuario */
		/* @var $em EntityManager */
		$em = $this->getDoctrine()->getEntityManager();
		$item = $em->getRepository('Area4ContableBundle:Items')->find($id);
		/* @var $item Items */
		if (!$item) {
			throw $this->createNotFoundException('Unable to find Items entity.');
		}

		$form = $this->createForm(new Items2Type(), $item);

		$request = $this->getRequest();

		$form->bindRequest($request);

		if ($form->isValid()) {
			$em->persist($item);
			$item->getDocumento()->calcularTotal();
			$em->persist($item->getDocumento());

			$em->flush();
		} else {
			return $this->render('Area4ContableBundle:Default:ver.html.twig',
											array(
									'prod' => $item->getProducto(),
									'user' => $sf2user,
							));
		}

		$url = $this->generateUrl('documento_show',
						array(
				'id' => $item->getDocumento()->getId()
						));
		return new RedirectResponse($url);


		return array(
				'entity' => $item->getDocumento()
		);
	}

	/**
	 * @route("/cerrarFactura/{id}", name="cerrarFactura")
	 * @Template()
	 */
	public function cerrarFacturaAction($id) {
		/* @var $em EntityManager */
		$em = $this->getDoctrine()->getEntityManager();
		$doc = $em->getRepository('Area4ContableBundle:Documento')->find($id);
		/* @var $doc Documento */
		$doc->cerrar();
		$em->persist($doc);
		$em->flush();
		/**
		 * Definir destinos
		 *
		 */
		$destinos = "";
		$config = $this->container->getparameter('mail_envio');
		if ($config == 1 || $config == 3) {
			$destinos = $this->container->getParameter('mail_definido');
		}
		if ($config == 3) {
			$destinos += ";";
		}
		if ($config == 2 || $config == 3) {
			$destinos = $doc->getCliente()->getPemail();
		}

		/**
		 * @todo mandar correos
		 */
		$mailer = $this->get('mailer');
		/* @var $mailer */
		$message = \Swift_Message::newInstance()
						->setContentType('text/html')
						->setSubject('Orden de Pedido ')
						->setFrom('info@vyfdistribuciones.com')
						->setTo($destinos)
						->setBody($this->renderView('Area4ContableBundle:Default:Factura.html.twig',
										array('doc' => $doc)))
		;
		$this->get('mailer')->send($message);
		return array();
	}

	/**
	 * @route("/movimientos", name="movimientos")
	 * @Template()
	 * Muestra un menu de los movimientos que puedes crear
	 */
	public function movimientosAction() {
		/* @var $em EntityManager */
		$em = $this->getDoctrine()->getEntityManager();
		$TR = $em->getRepository('Area4ContableBundle:Tipo');
		/* @var $TR \Area4\ContableBundle\Entity\TipoRepository */
		$tipos = $TR->listaMenu();
		return array(
				'tipos' => $tipos,
		);
	}

	/**
	 * @route("/movimiento/{tipoNom}", name="admin_movimiento")
	 * @Template()
	 */
	public function adminMovimientoAction($tipoNom) {
		/* @var $em EntityManager */
		$em = $this->getDoctrine()->getEntityManager();
		$TR = $em->getRepository('Area4ContableBundle:Tipo');
		/* @var $TR \Area4\ContableBundle\Entity\TipoRepository */
		/* @var $tipo \Area4\ContableBundle\Entity\Tipo */
		$tipo = $TR->findByNombre($tipoNom);
		if (!\is_object($tipo[0])) {
			throw $this->createNotFoundException('No encontrado el tipo:' . $tipoNom);
		}
		$MR = $em->getRepository('Area4ContableBundle:Documento');
		/* @var $MR \Area4\ContableBundle\Entity\DocumentoRepository */
						$listado = $MR->findByTipo($tipo[0]);
		return array(
				'tipo_id' =>  $tipo[0]->getId(),
				'listado' => $listado,
		);
	}

}
