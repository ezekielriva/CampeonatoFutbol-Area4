<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\CampeonatoBundle\Entity\InscripcionesRepository;

class InscripcionesType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('fecha_inicio','date',array(
                'label' => 'Fecha de inicio',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'))
            ->add('fecha_finalizacion','date',array(
                'label' => 'Fecha de finalización',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'))
            ->add('tipo','choice',array(
                'choices' => InscripcionesRepository::getTipoInscripciones(),
                ))
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_inscripcionestype';
    }
}
