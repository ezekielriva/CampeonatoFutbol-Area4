<?php

namespace Area4\CampeonatoBundle\Tests\Entity; 

use Symfony\Component\Validator\ValidatorFactory,
	Area4\CampeonatoBundle\Entity\Jugador,
	Area4\CampeonatoBundle\Entity\Equipo,
	Area4\CampeonatoBundle\Entity\Categoria;

/**
*  Test de la Entidad Jugador
* @TODO Test el Jugador con el GrupoFamiliar
* @TODO 
* assertEquals($valor_esperado, $valor_obtenido, $mensaje)
*/
class JugadorTest extends \PHPUnit_Framework_TestCase
{
	private $validator; // ValidatorFactory
	protected $equipo; // Equipo de prueba
	protected $jugador; // Jugador de prueba
	protected $categoria; // Categoria de prueba

	/**
	* Inicializador de las variables mocks 
	*/
	public function setUp()
	{
		$this->validator = ValidatorFactory::buildDefault()->getValidator();

		// Seteamos equipo de prueba
		$this->equipo = new Equipo();
		$this->equipo->setNombre('Tucuman');
		
		// Seteamos categoria de prueba
		$this->categoria = new Categoria();
		$this->categoria->setNombre('Primera');
		$this->categoria->setEdadIni(17);
		$this->categoria->setEdadFin(90);
	}
	/**
	* Test de validacion de la Entidad
	*/
	public function testValidation()
	{
		$jugador = new Jugador();

		$errores = $this->validator->validate($jugador);
		$error = $errores[0];
		return array($errores, $error);
	}
	/**
	* Test que prueba el ingreso de DNI sin Puntos
	*/
	public function testDni()
	{
		$jugador = new Jugador();
		$jugador->setDni('31.369.357');
		$errores = $this->validator->validate($jugador);

		$this->assertEquals('31369357', $jugador->getDni(), 'No se quitaron los "." del DNI.');

		$error = $errores[0];
		return array($errores, $error);
	}
	/**
	*
	*/
	public function testFechaNacimiento()
	{
		$jugador = new Jugador();
		$jugador->setFechaNac(new \Datetime('today'));

		$this->assertEquals(new \Datetime('today'), $jugador->getFechaNac(), 'No se cargo la fecha de Nacimiento.');
	}
	/**
	* Test de Creacion de Jugador
	* @TODO Completarlo
	*/
	public function testCreateJugador()
	{
		$jugador = new Jugador();
		$errores = $this->validator->validate($jugador);
		
		$this->testDni(); //Incluye el test de DNI
		$this->testFechaNacimiento(); //Incluye tes de Fecha de Nacimiento

		$jugador->setEquipo($this->equipo);
		$this->assertEquals($this->equipo, $jugador->getEquipo()->last(), 'No se cargo el Equipo.');

		$jugador->setCategoria($this->categoria);
		$this->assertEquals($this->categoria, $jugador->getCategoria(), 'No se cargo la Categoria.');		

		$error = $errores[0];
		return array($errores, $error);
	}
}