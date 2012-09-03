<?php

namespace Area4\ContableBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\ContableBundle\Entity\Tipo;

class TipoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('letra')
            ->add('plata','choice',array(
                'label' => 'Mueve dinero',
                'choices' => Tipo::getPlataChoices(),
                ))
            /*->add('stock','choice',array(
                'label' => 'Mueve stock',
                'choices' => Tipo::getStockChoices(),
                ))*/
        ;
    }

    public function getName()
    {
        return 'area4_contablebundle_tipotype';
    }
}
