<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PartidoEditType extends PartidoType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $array = array ();
        for ($i=1; $i<33; $i++)
            $array[] = $i;

        $builder
            ->add('dia')
            ->add('hora')
            ->add('fecha','choice',array(
                'choices' => $array,
            ))
            ->add('resultadol','text')
            ->add('resultadov','text')
            ->add('estado','choice',array(
                'choices' => array ('Por jugarse','Jugándose','Suspendido','Finalizado')
            ))
            ->add('local')
            ->add('visitante')
            ->add('Categoria')
            ->add('Campeonato')
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_partidotype';
    }
}
