<?php

namespace Area4\CampeonatoBundle\Tests\Entity; 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\ValidatorFactory;

use Area4\CampeonatoBundle\Entity\Campeonato,
	Area4\CampeonatoBundle\Entity\Equipo
;
use Area4\UsuarioBundle\Entity\Usuario;

/**
*  Test de la Entidad Campeonato
*
*/
class CampeonatoTest extends WebTestCase
{
	/**
	 * Test para agregar equipos al campeonato
	 * Test:    No se puede agregar el mismo equipo al campeonato
	 *
	 * @author ezekiel
	 **/
	public function testAddEquipo()
	{
		$campeonato = new Campeonato();
		$equipo = new Equipo();
		$equipo->setNombre('abc');

		for ($i=0; $i < 10; $i++) { 
			if ($i === 0) { //Agrego el equipo repetido al inicio
				$campeonato->addEquipo($equipo);
				continue;
			}

			if ($i === 9) { //Agrego el equipo repetido al final
				$campeonato->addEquipo($equipo);
				continue;
			}

			$campeonato->addEquipo(new Equipo());
		}

		$this->assertEquals(9, count( $campeonato->getEquipo() ), 'Cantidad invalida de equipos' );
	}
}