<?php

namespace Area4\UsuarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Area4\UsuarioBundle\Repository\UsuarioRepository;
//use Area4UsuarioBundle\Repository\UsuarioRepository;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);
        //Nuevos campos
    }
		
		public function getName() {
			return "usuario";
		}
}