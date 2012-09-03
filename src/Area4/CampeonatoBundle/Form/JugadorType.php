<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\CampeonatoBundle\Entity\EquipoRepository;

class JugadorType extends AbstractType {

	public function buildForm(FormBuilder $builder, array $options) {
		$builder
                    ->add('dni',"text",array(
                            'required' => true,
                        ))
                    ->add('nombre')
                    ->add('apellido')
                    ->add('fechadeNacimiento','date',array(
                            'widget' => 'single_text',
                            'format' => 'dd/MM/yyyy',
                            'label' => 'Fecha de nacimiento (dd/MM/aaaa)'
                        ))
                    //->add('equipo')
		;
	}

	public function getName() {
		return 'area4_campeonatobundle_jugadortype';
	}
}
