<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class agregarJugadorPartidoType extends AbstractType {

	public function buildForm(FormBuilder $builder, array $options) {
		$builder
                    ->add('dni','text')
                   // ->add('camiseta','text')
                    ->add('Equipo','text')
		;
	}

	public function getName() {
		return 'area4_campeonatobundle_agregarjugadorpartidotype';
	}
}
