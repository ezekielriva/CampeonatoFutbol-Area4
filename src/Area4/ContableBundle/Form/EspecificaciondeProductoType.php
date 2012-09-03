<?php

namespace Area4\ContableBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EspecificaciondeProductoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('fecha_vigencia_inicio','date',array(
                'label' => 'Fecha de Vigencia [inicio]',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                ))
            ->add('fecha_vigencia_finalizacion','date',array(
                'label' => 'Fecha de Vigencia [Finalización]',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                ))
            ->add('fecha_vencimiento','date',array(
                'label' => 'Fecha de Vencimiento',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                ))
        ;
    }

    public function getName()
    {
        return 'area4_contablebundle_especificaciondeproductotype';
    }
}
