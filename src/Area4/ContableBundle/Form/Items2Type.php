<?php

namespace Area4\ContableBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Items2Type extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {    $builder
            ->add('cantidad','text')
           // ->add('precio_u','hidden')
           // ->add('Documento','hidden')
          //  ->add('Producto','hidden')
        ;
       
    }

    public function getName()
    {
        return 'area4_contablebundle_itemstype';
    }
}
