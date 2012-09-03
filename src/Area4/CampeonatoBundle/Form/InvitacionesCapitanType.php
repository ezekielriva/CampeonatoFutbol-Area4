<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\UsuarioBundle\Repository\UsuarioRepository;

class InvitacionesCapitanType extends AbstractType
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
                'label' => 'Emails de los Capitanes de los Equipos (separados por ",")'
                ))
            /*->add('tipo','choice',array(
                    'choices' => UsuarioRepository::getAllLevels(),
                ))*/
            ->add('Campeonato','hidden')
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_inscripciontype';
    }
}
