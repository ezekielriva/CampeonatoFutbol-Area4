<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\CampeonatoBundle\Entity\EquipoRepository;

class PartidoEditType extends PartidoType
{
    /**
     * Campeonato
     *
     * @var 
     **/
    private $campeonato;

    public function setCampeonato($campeonato){
        $this->campeonato = $campeonato;
    }
    public function getCampeonato(){
        return $this->campeonato;
    }


    public function buildForm(FormBuilder $builder, array $options)
    {
        $array = array ();
        for ($i=1; $i<33; $i++)
            $array[$i] = $i;

        $builder
            ->add('diaHora','datetime', array(
                'label' => 'Dia - Hora',
                'attr' => array('class'=>'datetime'),
                ))
            ->add('fecha','choice',array(
                'choices' => $array,
            ))
            ->add('local','entity',array(
                'class' => 'Area4CampeonatoBundle:Equipo',
                'label' => 'Equipo local',
                'query_builder' => function (EquipoRepository $er){
                        return $er->createQueryBuilder('e')
                                    ->join('e.campeonato','c')
                                    ->where('c.id = '.$this->campeonato->getId());
                    }
                ))
            ->add('resultadol','text',array(
                'label' => 'Resultado del Equipo Local',
                ))
            ->add('visitante','entity',array(
                'class' => 'Area4CampeonatoBundle:Equipo',
                'label' => 'Equipo visitante',
                'query_builder' => function (EquipoRepository $er){
                        return $er->createQueryBuilder('e')
                                    ->join('e.campeonato','c')
                                    ->where('c.id = '.$this->campeonato->getId());
                    }
                ))
            ->add('resultadov','text',array(
                'label' => 'Resultado del Equipo visitante',
                ))

        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_partidotype';
    }
}
