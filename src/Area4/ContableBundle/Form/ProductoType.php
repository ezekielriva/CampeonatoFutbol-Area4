<?php

/**
 * Description of articuloType
 *
 * @author jme
 */

namespace Area4\ContableBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\ContableBundle\Entity\ProductoRepository;
use Doctrine\ORM\EntityRepository;

class ProductoType extends AbstractType {

	public function buildForm(FormBuilder $builder, array $options) {
		$builder
					->add('codigo','text')
                    ->add('especificaciondeProducto','entity',array(
                    	'class' => 'Area4ContableBundle:EspecificaciondeProducto',
                    	'label' => 'Elije la Especificacion de Producto',
                    	'query_builder' => function (EntityRepository $er){
                    			$fecha = new \DateTime('now');
                    			$fechaWQuote = '\''.date_format($fecha,'y-m-d').'\'';
		                        return $er->createQueryBuilder('ep')
					                        ->where('ep.fecha_vigencia_inicio <= '.$fechaWQuote)
					                        ->andWhere('ep.fecha_vigencia_finalizacion >= '.$fechaWQuote)
					                        ->orderBy('ep.nombre','ASC');
		                    }
                    	))
                    ->add('precio','text')
		;
	}

	public function getName() {
		return 'area4_contablebundle_productotype';
	}

}

?>
