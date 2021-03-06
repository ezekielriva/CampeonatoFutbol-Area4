<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EquipoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('colores','entity',array(
                    'class' => 'Area4CampeonatoBundle:Colores',
                    'multiple' => 'true',
                    'expanded' => 'true'
                ))
            //->add('imagen','file')
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_equipotype';
    }
}
