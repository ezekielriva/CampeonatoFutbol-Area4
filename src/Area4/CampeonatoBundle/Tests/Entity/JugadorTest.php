<?php

namespace Area4\CampeonatoBundle\Tests\Entity; 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\ValidatorFactory,
	Area4\CampeonatoBundle\Entity\Jugador,
	Area4\CampeonatoBundle\Form\JugadorType
	;
use Area4\UsuarioBundle\Entity\Usuario;

/**
*  Test de la Entidad Jugador
*
* assertEquals($valor_esperado, $valor_obtenido, $mensaje)
*/
class JugadorTest extends WebTestCase
{
	private $validator; // ValidatorFactory


	protected function getUsuario()
	{
		return $this->getMock('Area4\UsuarioBundle\Entity\Usuario');
	}
	protected function getJugador()
    {
        return $this->getMock('Area4\CampeonatoBundle\Entity\Jugador');
    }

	/**
	* Inicializador de las variables mocks 
	*/
	public function setUp()
	{
		$this->validator = ValidatorFactory::buildDefault()->getValidator();
	}
	/**
	 * Valida jugador
	 *
	 * @author ezekiel
	 **/
	private function validar(Jugador $jugador)
	{
		$errores = $this->validator->validate($oferta);
		$error = $errores[0];
		return array($errores, $error);
	}
	/**
	* Test que prueba el ingreso de DNI sin Puntos
	*/
	public function testSetters()
	{
		$jugador = new Jugador();
		$this->assertNull($jugador->getDni());
		$this->assertNull($jugador->getFechadeNacimiento());

		// DNI
		$jugador->setDni('31.369.357');
		$this->assertEquals('31369357', $jugador->getDni(), 'No se quitaron los "." del DNI.');

		//FECHA
		$jugador->setFechadeNacimiento(new \Datetime('today'));
		$this->assertEquals(new \Datetime('today'), $jugador->getFechadeNacimiento(), 'No se cargo la fecha de Nacimiento.');

		//UpperCase
		$jugador->setNombre('aBc');
		$jugador->setApellido('aBc');
		$this->assertEquals('ABC', $jugador->getNombre(), 'No se puso el nombre en mayusculas.');
		$this->assertEquals('ABC', $jugador->getApellido(), 'No se puso el apellido en mayusculas.');

		//SLUG
		//$this->assertEquals("31369357 - ABC, ABC",$jugador->generateSlug(), 'No se genero el slug correctamente');
		
	}

	/**
	 * I dont have a fucking idea, whats i doing
	 *
	 * @author ezekiel
	 **/
	public function testValidation()
	{
		$jugador = new Jugador();
		
		$errores = $this->validator->validate($jugador);

		$this->assertGreaterThan(0, count($errores), 'No idea');
	}
	/**
	* Test de Creacion de Jugador
	* 
	*/
	public function testCreateJugador()
	{/*
		$jugador = $this->generarJugador();

		$client = static::createClient();
		$client->followRedirects(true);
		
		$crawler = $client->request('GET', 'app.php/jugador/inscribirse');	
		$formulario = $crawler->selectButton('Inscribirse')->form($jugador);

		$crawler = $client->submit($formulario);
		$this->assertTrue($client->getResponse()->isSuccessful(),'No se retorno el explorador 200 a 300	');

		*/

	}
}