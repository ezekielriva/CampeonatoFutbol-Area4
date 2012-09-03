<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Area4\ContableBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Description of DivisaType
 *
 * @author jme
 */
class DivisaType extends \Area4\ContableBundle\Form\ComprobanteType {

	public function buildForm(FormBuilder $builder, array $options) {
		$builder
						->add('Divisa', 'entity',
						array(
								'class' => 'Area4\ContableBundle\Entity\Divisa',
										'attr'=> array(
												'onChange'=> 'cambiarDivisa(this.value);'
										)))
						->add('DivisaValor', null,array(
								'label' => 'Valor de Cambio'
						))
		;
//put your code here
	}

}

?>
