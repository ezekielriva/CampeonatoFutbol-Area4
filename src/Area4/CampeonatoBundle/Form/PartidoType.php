<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\CampeonatoBundle\Entity\EquipoRepository,
    Area4\CampeonatoBundle\Entity\PartidoRepository;

class PartidoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $fecha = array ();
        for ($i=1; $i<33; $i++)
            $fecha[] = $i;

        $builder
            ->add('dia')
            ->add('hora')
            ->add('fecha','choice',array(
                'choices' => $fecha,
            ))
//            ->add('resultadol')
//            ->add('resultadov')
            ->add('estado','choice',array(
                'choices' => PartidoRepository::getEstados(),
            ))
            ->add('local')
            ->add('bloqueLocal','choice', array(
                'choices' => EquipoRepository::getBloques(),
                'label' => 'Bloque del Equipo Local',
                ))
            ->add('colorLocal','choice', array(
                'choices' => EquipoRepository::getColores(),
                'label' => 'Color del Equipo Local'
                ))
            ->add('visitante')
            ->add('bloqueVisitante','choice', array(
                'choices' => EquipoRepository::getBloques(),
                'label' => 'Bloque del Equipo Visitante',
                ))
            ->add('colorVisitante','choice', array(
                'choices' => EquipoRepository::getColores(),
                'label' => 'Color del Equipo Visitante'
                ))
            ->add('Categoria')
            ->add('Campeonato')
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_partidotype';
    }
}
