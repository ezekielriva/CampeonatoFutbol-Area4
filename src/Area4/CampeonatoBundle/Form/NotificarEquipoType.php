<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\CampeonatoBundle\Entity\Campeonato;
use Area4\CampeonatoBundle\Entity\EquipoRepository;

class NotificarEquipoType extends AbstractType
{
    /**
     * Constructor
     *
     * @author ezekiel
     **/
    public function __construct()
    {
        $this->campeonato = -1;
    }
    /**
     * Campeonato
     *
     * @var Campeonato
     **/
    private $campeonato;

    /**
     * Setter campeonato
     *
     * @author ezekiel
     **/
    public function setCampeonato($campeonato)
    {
        $this->campeonato = $campeonato;
    }

    /**
     * Getter campeonato
     *
     * @return Campeonato
     * @author ezekiel
     **/
    public function getCampeonato()
    {
        return $this->campeonato;
    }
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('Equipo','entity',array(
                'class' => 'Area4CampeonatoBundle:Equipo',
                'multiple' => 'true',
                'expanded' => 'true',
                'query_builder' => function(EquipoRepository $er) { 
                                                return $er->findNotPlayInCampeonato($this->campeonato); 
                                    }
                ))
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_notificacionestype';
    }
}
