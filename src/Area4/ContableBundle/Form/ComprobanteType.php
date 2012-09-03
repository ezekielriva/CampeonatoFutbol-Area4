<?php
namespace Area4\ContableBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\ContableBundle\Form\DocumentoType;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComprobanteType
 *
 * @author jme
 */
class ComprobanteType extends DocumentoType  {

	public function buildForm(FormBuilder $builder, array $options) {
		$builder
	//					->add('tipo')
//						->add('numero')
						->add('fecha')
						->add('Cliente','entity', array(
            //'widget' => 'entity',
            'class' => 'Area4\ContableBundle\Entity\Cliente',
        ))
						//       ->add('created_at')
						//      ->add('update_at')
					//	->add('Divisa')
						->add('FPago')
//						->add('total')
//						->add('estado')
		//     ->add('created_by')
		//    ->add('update_by')
		;
	}


	public function getName() {
		return 'area4_contablebundle_comprobantetype';
	}
}

?>
