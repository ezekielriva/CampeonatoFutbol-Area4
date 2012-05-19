<?php
    
namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CampeonatoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('deporte')
            ->add('Equipos')
            ->add('Categorias')
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_campeonatotype';
    }
}
