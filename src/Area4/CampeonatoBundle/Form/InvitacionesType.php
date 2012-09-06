<?php

namespace Area4\CampeonatoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\UsuarioBundle\Repository\UsuarioRepository;

class InvitacionesType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            /*->add('fecha')
            /*->add('token','text',array(
                'attr' => array('readonly' => 'true'),
                ))*/
            ->add('email','textarea',array(
                //'attr' => array('rows' => '20', 'cols' => '125'),
                'label' => 'Emails (separados con \',\')',
                'attr' => array('class' => 'usersAutoComplete'),
                ))
            /*->add('tipo','choice',array(
                    'choices' => UsuarioRepository::getAllLevels(),
                ))*/
        ;
    }

    public function getName()
    {
        return 'area4_campeonatobundle_inscripciontype';
    }
}
