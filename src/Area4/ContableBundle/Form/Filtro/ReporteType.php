<?php

namespace Area4\ContableBundle\Form\Filtro;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ReporteType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('fecha_inicio','date')
            ->add('fecha_fin','date')
        ;
    }

    public function getName()
    {
        return 'area4_contablebundle_reportetype';
    }
}
