<?php

namespace Area4\CampeonatoBundle\Tests\Entity; 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\ValidatorFactory;

use Area4\CampeonatoBundle\Entity\Partido,
	Area4\CampeonatoBundle\Entity\Equipo
;

/**
*  Test de la Entidad Partido
*
* assertEquals($valor_esperado, $valor_obtenido, $mensaje)
*/
class PartidoTest extends WebTestCase
{
	/**
	 * Test que revisa a los equipos locales y visitantes
	 * Test:	1. Que local != Visitante
	 *			2. Que visistenate != local
	 * @author ezekiel
	 **/
	public function testEquipos()
	{
		$equipo1 = new Equipo();
		$equipo1->setNombre('abc');

		$equipo2 = new Equipo();
		$equipo2->setNombre('xyz');

		$partido = new Partido();

		// Asigno local primero
		$partido->setLocal($equipo1);
		$partido->setVisitante($equipo1);

		$this->assertNotEquals( $partido->getVisitante(), $partido->getLocal(), 
			'No pueden ser los mismos equipos' );

		$partido->setLocal($equipo1);
		$partido->setVisitante($equipo2);

		$this->assertNotEquals( $partido->getVisitante(), $partido->getLocal(), 
			'No pueden ser los mismos equipos' );

		// Asigno visitante primero
		$partido->setVisitante($equipo1);
		$partido->setLocal($equipo1);

		$this->assertNotEquals( $partido->getVisitante(), $partido->getLocal(), 
			'No pueden ser los mismos equipos' );

		$partido->setVisitante($equipo2);
		$partido->setLocal($equipo1);

		$this->assertNotEquals( $partido->getVisitante(), $partido->getLocal(), 
			'No pueden ser los mismos equipos' );
	}

	/**
	 * Test de la citación 20 min antes del tiempo indicado
	 *
	 * @author ezekiel
	 **/
	public function testCitacion()
	{
		$partido = new Partido();
		$partido->setDiahora( new \DateTime('18:40:00')  );

		$this->assertEquals( '18:20:00', date_format($partido->getCitacion(), 'H:i:s') );
	}
}