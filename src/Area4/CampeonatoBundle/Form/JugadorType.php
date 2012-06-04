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
                    ->add('equipo')
               /*     ->add('foto','file', array(
                        'required' => false,
                    ))
                    ->add('email','email', array(
                        'required' => false,
                    ))
                    ->add('carnet')
                    ->add('ocupacion')
                    ->add('facebook')
                    ->add('observaciones')
                    
                    ->add('bloque','choice',array(
                        'choices' => EquipoRepository::getBloques(),
                    ))
                    ->add('color','choice',array(
                        'choices' => EquipoRepository::getColores(),
                    ))
                    ->add('Categoria')*/
		;
	}

	public function getName() {
		return 'area4_campeonatobundle_jugadortype';
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
