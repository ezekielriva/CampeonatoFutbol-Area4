<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SelectArbitroType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
             ->add('arbitro1','entity_id',array(
                    'class' => 'Area4\CampeonatoBundle\Entity\Arbitro',
                    'query_builder' => function(EntityRepository $repo){
                    							return $repo->findAll();
                    					},
                    'hidden' => false,
                ))
                ->add('arbitro2','entity_id',array(
                    'class' => 'Area4\CampeonatoBundle\Entity\Arbitro',
                    'property' => 'id',
                    'hidden' => false,
                ))
                ->add('obs','textarea')
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_arbitrotype';
    }
}
