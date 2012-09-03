<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class NotificarEquipoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('Equipo','entity',array(
                'class' => 'Area4CampeonatoBundle:Equipo',
                'multiple' => 'true',
                'expanded' => 'true'
                ))
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_notificacionestype';
    }
}
