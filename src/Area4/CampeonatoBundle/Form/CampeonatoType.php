<?php
    
namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\CampeonatoBundle\Entity\CampeonatoRepository;

class CampeonatoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('categoria','choice',array(
                'choices' => CampeonatoRepository::getCategorias(),
                ))
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_campeonatotype';
    }
}
