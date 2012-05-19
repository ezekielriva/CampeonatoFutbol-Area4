<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CategoriaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $edad = array(); $anio = array();
        for ($i=5; $i<=80; $i++){
            $edad[] = $i;
            $anio[] = 2007 + $i;
        }
        $builder
            ->add('nombre')
            ->add('edadIni', 'choice', array(
                'label' => 'Edad incial permitida',
                'choices' => $edad,
            ))
            ->add('edadFin', 'choice', array(
                'label' => 'Edad final permitida',
                'choices' => $edad,
            ))
            ->add('anio_camp', 'choice', array(
                'label' => 'Año actual de campeonato',
                'choices' => $anio,
            ))
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_categoriatype';
    }
}
