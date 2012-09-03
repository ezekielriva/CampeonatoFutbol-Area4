<?php

namespace Area4\ContableBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ItemsType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
     $builder
            ->add('cantidad')
            ->add('precio_u')
            ->add('precio_t')
            ->add('created_at')
            ->add('updated_at')
            ->add('Documento')
            ->add('Producto')
            ->add('responsable')
            ->add('created_by')
            ->add('updated_by')
        ;
    }

    public function getName()
    {
        return 'area4_contablebundle_itemstype';
    }

		 public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Area4\ContableBundle\Entity\Items',
        );
    }
}
