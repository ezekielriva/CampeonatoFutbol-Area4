<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\CampeonatoBundle\Entity\EquipoRepository,
    Area4\CampeonatoBundle\Entity\PartidoRepository;

class PartidoType extends AbstractType
{
    /**
     * Campeonato
     *
     * @var integer
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
        $fecha = array ();
        for ($i=1; $i<33; $i++)
            $fecha[$i] = $i;


        $builder
            ->add('diaHora','datetime', array(
                'label' => 'Dia - Hora',
                'attr' => array('class'=>'datetime'),
                ))
            ->add('fecha','choice',array(
                'choices' => $fecha,
            ))
            ->add('Campeonato','entity',array(
                'class' => 'Area4CampeonatoBundle:Campeonato',
                'attr' => array('hidden'=>'true')
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
            ->add('visitante','entity',array(
                'class' => 'Area4CampeonatoBundle:Equipo',
                'label' => 'Equipo visitante',
                'query_builder' => function (EquipoRepository $er){
                        return $er->createQueryBuilder('e')
                                    ->join('e.campeonato','c')
                                    ->where('c.id = '.$this->campeonato->getId());
                    }
                ))
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_partidotype';
    }

    /** Data absolutly important !
    
    $this->buildForm($type, $entity, array('repository' => $er))
    
    */
}
