<?php

namespace Area4\CampeonatoBundle\Tests\Entity; 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\ValidatorFactory;

use Area4\CampeonatoBundle\Entity\Equipo,
	Area4\CampeonatoBundle\Entity\Jugador,
	Area4\CampeonatoBundle\Entity\Campeonato,
	Area4\CampeonatoBundle\Entity\Colores
;
use Area4\UsuarioBundle\Entity\Usuario;

/**
*  Test de la Entidad Equipo
*
* assertEquals($valor_esperado, $valor_obtenido, $mensaje)
*/
class EquipoTest extends WebTestCase
{
	/**
	 * Test setup
	 *
	 * @author ezekiel
	 **/
	public function setUp()
	{

	}

	/**
	 * Test setters simples
	 *
	 * @author ezekiel
	 **/
	public function testSetter()
	{
		$equipo = new Equipo();

		//nombre
		$equipo->setNombre('aBc');
		$this->assertEquals('ABC',$equipo->getNombre());
	}

	/**
	 * Test para el agregado de jugadores
	 * Idea: 	Se agrega un jugador al equipo.
	 *			Se disminuye los cupos
	 *			Maximo N por equipo
	 * Test:	Asignamos un numero N de cupos
	 *		1.  Agregamos N+m jugadores al equipo = N cupos
	 * @author ezekiel
	 **/
	public function testAddJugadores()
	{
		$n = rand(1,11);
		$m = rand(1,5);

		if ($n < $m) {
			$n += $m;
		}

		$equipo = new Equipo();
		$equipo->setCupos( $n );

		for ($i=0; $i < ($n + $m); $i++) { 
			$equipo->addJugador(new Jugador());
		}

		$this->assertEquals($n, count($equipo->getJugadores()));
	}

	/**
	 * Test para el agregado de campeonatos
	 * Test:	Agregar Campeonatos al equipo.
	 * Comp:	Un equipo no puede jugar 2 veces el mismo campeonato.
	 *
	 * @author ezekiel
	 **/
	public function testAddCampeonato()
	{
		$campeonato1 = new Campeonato();
		$campeonato1->setNombre('1');

		$campeonato2 = new Campeonato();
		$campeonato2->setNombre('2');

		$campeonato3 = new Campeonato();
		$campeonato3->setNombre('3');

		$equipo = new Equipo();

		$equipo->addCampeonato($campeonato1);
		$equipo->addCampeonato($campeonato2);
		$equipo->addCampeonato($campeonato3);
		$equipo->addCampeonato($campeonato1); //Error de prepo

		$this->assertEquals(3, count( $equipo->getCampeonato() ), 'Cantidad de campeonatos invalida');
	}

	/**
	 * Test para el agregado de Colores
	 * Test:	Agregar colores al equipo
	 * Comp:	un equipo no puede tener mas de 3 colores
	 *
	 * @author ezekiel
	 **/
	public function testAddColores()
	{
		$equipo = new Equipo();

		for ($i=0; $i < 5; $i++) { 
			$equipo->addColores(new Colores());
		}

		$this->assertEquals( 3, count( $equipo->getColores() ), 'Cantidad de colores invalida');
	}

	/**
	 * Test para obtener el capitan del Equipo
	 *
	 * @author ezekiel
	 **/
	public function testGetCapitan()
	{
		$equipo = new Equipo();

		$capitan = new Jugador();
		$capitan->setUsuario( new Usuario() );
		$capitan->getUsuario()->addRole('ROLE_CAP');

		for ($i=0; $i < $equipo->getCupos() ; $i++) { 
			if ($i === 0) {
				$equipo->addJugador($capitan); continue;
			}
			$jugador = new Jugador();
			$jugador->setUsuario( new Usuario() );
			$jugador->getUsuario()->addRole('ROLE_JUG');
			$equipo->addJugador( $jugador );
		}

		$this->assertEquals( $capitan, $equipo->getCapitan(), 'No es el mismo capitan');
	}
}