<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\CampeonatoBundle\Entity\JugadorRepository;
use Doctrine\ORM\EntityRepository;
use Area4\CampeonatoBundle\Entity\novedad;

class novedadType extends AbstractType {
    /**
     * Equipos que juegan en el partido
     *
     * @var array
     **/
    private $equipos;

    /**
     * Agrega un equipo al array de equipos
     *
     * @return void
     * @author ezekiel
     **/
    public function addEquipo($equipo)
    {
        $this->equipos[] = $equipo;
    }

    public function buildForm(FormBuilder $builder, array $options) {  
        
        $builder
                ->add('minuto', 'text')
                ->add('tipo_novedad','choice',array(
                    'choices' => novedad::$TipoNovedadArray,
                ))
                ->add('Jugador','entity',array(
                    'class' => 'Area4CampeonatoBundle:Jugador',
                    'query_builder' => function (EntityRepository $er){
                        $query = $er->createQueryBuilder('j');
                        foreach ($this->equipos as $equipo) {
                            $query->orWhere('j.equipo = '.$equipo->getId());
                        }
                        return $query;
                    },
                ))
                ->add('obs', 'textarea', array(
                    'required' => false,
                    'label' => 'Observaciones'
                ))
        ;
    }

    public function getName() {
        return 'area4_campeonatobundle_novedadtype';
    }

}
