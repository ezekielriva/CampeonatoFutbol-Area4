<?php

/**
 * Description of articuloType
 *
 * @author jme
 */

namespace Area4\ContableBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArticuloType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('Jugador', 'entity_id',
                        array (
                            'class' => 'Area4\CampeonatoBundle\Entity\Jugador',
                            'property' => 'dni',
                            'hidden' => false,
                ))
                ->add('Producto', 'entity_id',
                        array(
                            'class' => 'Area4\ContableBundle\Entity\Producto',
                            'property' => 'id',
                            //'hidden' => false,
                            'attr' => array(
                                'size' => 5,
                                'onChange' => 'precioXCant();',
                                'onkeyup' => 'cuadroProCambiar(this.value);',
                                'onfocus' => 'this.select();',
                                'value' => ''
                        )))
                ->add('precio_u', 'text',
                        array(
                            'attr' => array(
                                'onChange' => 'calculaTotal();',
                                'onKeyup' => 'calculaTotal();',
                            ),
                            'label' => 'Costo',
                ))
                ->add('Documento', 'entity_id',
                        array(
                            'class' => 'Area4\ContableBundle\Entity\Documento',
                            'property' => 'id',
                            //'hidden' => true,
                ))
                
                ->add('cantidad', 'hidden',
                        array(
                            'attr' => array(
                                'onChange' => 'precioXCant();',
                                'onKeyup' => 'precioXCant();',
                            )
                ))
                

        ;
    }

    public function getName() {
        return 'area4_contablebundle_articulotype';
    }

    /* 	public function getDefaultOptions(array $options) {
      return array(
      'data_class' => 'Area4\ContableBundle\Entity\Items',
      );
      } */
}

?>
