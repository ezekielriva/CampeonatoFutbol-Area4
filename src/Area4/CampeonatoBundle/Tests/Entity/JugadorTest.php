<?php

namespace Area4\CampeonatoBundle\Tests\Entity; 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\ValidatorFactory,
	Area4\CampeonatoBundle\Entity\Jugador,
	Area4\CampeonatoBundle\Form\JugadorType
	;

/**
*  Test de la Entidad Jugador
* @TODO Test el Jugador con el GrupoFamiliar
* @TODO 
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
	* Test que prueba el ingreso de DNI sin Puntos
	*/
	public function testDni()
	{
		$jugador = new Jugador();
		$this->assertNull($jugador->getDni());
		$jugador->setDni('31.369.357');

		$this->assertEquals('31369357', $jugador->getDni(), 'No se quitaron los "." del DNI.');
	}
	/**
	*
	*/
	public function testFechaNacimiento()
	{
		$jugador = new Jugador();
		$this->assertNull($jugador->getFechadeNacimiento());
		$jugador->setFechadeNacimiento(new \Datetime('today'));

		$this->assertEquals(new \Datetime('today'), $jugador->getFechadeNacimiento(), 'No se cargo la fecha de Nacimiento.');
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

	/**
	 * Genera un jugador de prueba
	 *
	 * @return array
	 * @author ezekiel <ezerivadeneiral@gmail.com>
	 **/
	protected function generarJugador()
	{
		$formJugador = new JugadorType();
		return array(array(array(
				$formJugador->getName().'[dni]' => '1234567890',
				$formJugador->getName().'[nombre]' => 'Anonimo',
				$formJugador->getName().'[apellido]' => 'Anonimo1',
				$formJugador->getName().'[fechadeNacimiento]' => '00/00/0000',
				$formJugador->getName().'[equipo]' => '1',
				'fos_user_registration_form[email]' => 'anonimo'.uniqid().'@localhost.localdomain',
				'fos_user_registration_form[plainPassword][first]' => 'anonimo1234',
				'fos_user_registration_form[plainPassword][second]' => 'anonimo1234',
			)));
	}
}