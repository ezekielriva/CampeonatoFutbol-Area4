<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CambioController
 *
 * @author jme
 */

namespace Area4\ContableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Area4\ContableBundle\Form\Items2Type;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Area4\ContableBundle\Form\DocumentoType as Form;

class CambioController extends Controller {

	function getUpadte($monto, $origen, $destino) {
		$returnHtml = array();
		$page					= 'http://www.google.com/search?&q=' . $monto . '+' . $origen . '+in+' . $destino;
		$returnRawHtml = file_get_contents($page);
		preg_match_all('/<h2 class=r(.*)\<\/h2\>/Uis', $returnRawHtml, $returnHtml,
								 PREG_PATTERN_ORDER);
		if (isset($returnHtml[0][0])) {
			$gRate = strip_tags($returnHtml[0][0]);
			return $gRate;
		} else {
			return false;
		}
	}

	function divisas($de_divisa, $a_divisa, $monto) {
		$monto		 = urlencode($monto);
		$de_divisa = urlencode($de_divisa);
		$a_divisa	= urlencode($a_divisa);
		$params		= "q=$monto.$de_divisa=?$a_divisa";
		$url			 = file_get_contents("http://www.google.com/ig/calculator?hl=en&$params");
		$data			= explode(',', $url);
		foreach ($data as $num => $contenido) {
			if ($num == 1) {
				$long = strlen($contenido);
				$out	= substr($contenido, 6, $long - 7);
			}
		}
		return (double) $out;
	}

	/**
	 * REaliza el cambio a travez de google
	 * Pagina de Codigos   http://samples.unijimpe.net/currency/codes.php
	 * @route("/cambio/{origen}/{destino}", name="cambioFinanciero")
	 * defaults={"origen"="USD", "destino" = "ARS")
	  @template()
	 * @param String $origen
	 * @param String $destino
	 */
	public function cambioAction($origen, $destino) {
		$em = $this->getDoctrine()->getEntityManager();
		/* @var $em \Doctrine\ORM\EntityManager */
		/* @var $div \Area4\ContableBundle\Entity\Divisa */
		$div = $em->getReference('Area4ContableBundle:Divisa', 2);
		$div->actualizar();
		$em->persist($div);
		$em->flush();


		return array(
			//	'res' => $result,
				'res2' => $div->getValor(),
				);
	}

}

?>
