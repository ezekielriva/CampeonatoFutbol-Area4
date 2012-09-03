<?php

namespace Area4\ContableBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DocumentoType extends AbstractType {

	public function buildForm(FormBuilder $builder, array $options) {
		$builder
                    ->add('tipo')
//                    ->add('numero','text')
                    ->add('fecha')
//                    ->add('Responsable')
//                    ->add('created_at')
//                    ->add('update_at')
//                    ->add('total')
//                    ->add('estado')
//		    ->add('created_by')
//		    ->add('update_by')
		;
	}

	public function getName() {
		return 'area4_contablebundle_documentotype';
	}

}
