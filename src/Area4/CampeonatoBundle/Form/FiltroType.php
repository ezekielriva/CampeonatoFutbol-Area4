<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FiltroType extends AbstractType {

	public function buildForm(FormBuilder $builder, array $options) {
		$builder
                    ->add('sexo','choice',array(
                        'choices' => $this->getDefaultChoices('sexo'),
                    ))
                    ->add('Equipo',null,array(
//                        'class' => 'Area4CampeonatoBundle:Equipo',
                        'required' => false,
                        //'multiple' => false,
                    ))
                    ->add('Categoria',null,array(
                        'required' => false,
                    ))
		;
	}

	public function getName() {
		return 'area4_campeonatobundle_filtrotype';
	}

        /**
         * Devuelve el array de valores que se solicita por el parrametro.
         *
         * @param String $text
         * @example 'sexo', 'bloque', 'color'
         */
        private function getDefaultChoices($text){
            switch ($text){
                case 'sexo': return array(
                       -1 => 'Sin Filtro',
                        1 => 'Masculino',
                        0 => 'Femenino'
                    );
                case 'bloque': return array(
                    'Sin bloque', 'a', 'b', 'c', 'd'
                    );
                case 'color': return array(
                    'Sin color', 'rojo', 'azul', 'blanco', 'negro',
                );
            }
        }

   
}
