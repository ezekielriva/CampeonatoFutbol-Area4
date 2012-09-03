<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class NotificacionesType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        /*$builder
            //->add('descripcion')
            //->add('url')
            //->add('wasRead')
            ->add('Usuario','entity',array(
                'class' => 'Area4UsuarioBundle:Usuario',
                'multiple' => 'true',
                'expanded' => 'true'
                ))
        ;*/
    }

    public function getName()
    {
        return 'area4_campeonatobundle_notificacionestype';
    }
}
