<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class novedadType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $tpnov = array(
            'Gol-Local', 'Gol-Visitante', 'Tarjeta Verde', 'Tarjeta Amarilla',
            'Tarjeta Roja', 'Penal', 'Suspención de Partido', 'Lesión'
        );
        $builder
                ->add('minuto', 'text')
                ->add('tipo_novedad','choice',array(
                'choices' => $tpnov,
                ))
                ->add('obs', 'textarea', array(
                    'required' => false
                ))
                ->add('Partido')
                ->add('Jugador','entity_id',array(
                    //'class' => 'Area4CampeonatoBundle:Jugador',
                    'class' => 'Area4\CampeonatoBundle\Entity\Jugador',
                    'property' => 'dni',
                    'hidden' => false,
                ))
        ;
    }

    public function getName() {
        return 'area4_campeonatobundle_novedadtype';
    }

}
