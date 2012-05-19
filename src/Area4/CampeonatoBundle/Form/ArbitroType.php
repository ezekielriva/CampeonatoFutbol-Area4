<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArbitroType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('arbitro1','entity_id',array(
                    'class' => 'Area4CampeonatoBundle:Arbitro',
                    'property' => 'id',
                ))
            ->add('arbitro2','entity',array(
                    'class' => 'Area4CampeonatoBundle:Arbitro',
                    'property' => 'id',
                ))
            ->add('obs','textarea')
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_arbitrotype';
    }
}
