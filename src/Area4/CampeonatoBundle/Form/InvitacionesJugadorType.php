<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
//use Area4\UsuarioBundle\Repository\UsuarioRepository;
use Doctrine\ORM\EntityRepository;
use Area4\CampeonatoBundle\Entity\CampeonatoRepository;

class InvitacionesJugadorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder
            //->add('fecha')
            /*->add('token','text',array(
                'attr' => array('readonly' => 'true'),
                ))*/
            ->add('email','textarea',array(
                'attr' => array('rows' => '15', 'cols' => '40'),
                'label' => 'Emails de los Jugadores (separados por ",")'
                ))
            /*->add('tipo','choice',array(
                    'choices' => UsuarioRepository::getAllLevels(),
                ))*/
            // SELECT * FROM `Inscripciones` i WHERE CURDATE() Between i.fecha_inicio AND i.fecha_finalizacion
            ->add('Campeonato','entity',array(
                'class' => 'Area4CampeonatoBundle:Campeonato',
                'property' => 'nombre',
                'query_builder' => function(EntityRepository $er) {
                                $date = new \DateTime('now');
                                return $er->createQueryBuilder('c')
                                            ->join('c.Inscripciones','i','ON','i.Campeonato_id = c.id')
                                            ->where('\''.$date->format('Y-m-d').'\' BETWEEN i.fecha_inicio AND i.fecha_finalizacion');
                            },
                ))
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_inscripciontype';
    }
}
