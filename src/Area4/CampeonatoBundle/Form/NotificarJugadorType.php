<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class NotificarJugadorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('url','textarea',array(
                'attr' => array('class' => 'usersAutoComplete', 'cols' => '60', 'rows' => '10'),
                'label' => 'Nombres de usuarios separados por ,'
                ))
            ->add('Equipo','entity',array(
                'class' => 'Area4CampeonatoBundle:Equipo',
                'label' => '',
                'attr' => array('hidden' => 'true'),
                ))
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_notificacionestype';
    }
}
