<?php

namespace Area4\CampeonatoBundle\Tests\Entity; 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\ValidatorFactory;

use Area4\CampeonatoBundle\Entity\Inscripciones,
	Area4\CampeonatoBundle\Entity\Jugador,
	Area4\CampeonatoBundle\Entity\Campeonato,
	Area4\CampeonatoBundle\Entity\Colores
;
use Area4\UsuarioBundle\Entity\Usuario;

/**
*  Test de la Entidad Inscripciones
*
* assertEquals($valor_esperado, $valor_obtenido, $mensaje)
*/
class InscripcionesTest extends WebTestCase
{
	/**
	 * Test de las fechas
	 * Test:	la fecha de finalización >= fecha inicio
	 *
	 * @author ezekiel
	 **/
	public function testFechas()
	{
		$inscripcion = new Inscripciones();

		$inscripcion->setFechaInicio( new \DateTime('now') );

		$this->assertFalse( $inscripcion->setFechaFinalizacion('1900-01-01'), 
			'No se puede asignar una fecha de finalizacion menor a la de inicio' );
	}
}