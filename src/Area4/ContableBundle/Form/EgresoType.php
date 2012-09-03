<?php

namespace Area4\ContableBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EgresoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('fecha')
            ->add('numero_comprobante')
            ->add('importe','text')
            //->add('Usuario')
            //->add('created_at')
            //->add('update_at')
            ->add('observaciones','textarea')
        ;
    }

    public function getName()
    {
        return 'area4_contablebundle_egresotype';
    }
}
