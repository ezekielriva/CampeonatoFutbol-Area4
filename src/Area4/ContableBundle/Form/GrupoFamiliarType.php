<?php

namespace Area4\ContableBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GrupoFamiliarType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
           //->add('apellido')
            ->add('dni','text',array(
                'label' => 'DNI del jugador responsable del grupo familiar',
                ))
            /*->add('Jugador','entity',array(
                'class' => 'Area4\CampeonatoBundle\Entity\Jugador',
                'multiple' => true,
            ))*/
        ;
    }

    public function getName()
    {
        return 'area4_contablebundle_grupofamiliartype';
    }
}
