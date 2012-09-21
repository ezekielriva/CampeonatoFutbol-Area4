<?php

namespace Area4\CampeonatoBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Area4\ContableBundle\Entity\Documento, 
	Area4\ContableBundle\Entity\LineadeDocumento;

class DocumentoTest extends WebTestCase
{   
	/**
	 * Set - Get test
	 *
	 * @author ezekiel
	 **/
	public function testSetGet()
	{
		$documento = new Documento();
		$documento->setNumero('1234');

		$this->assertEquals( '000000001234', $documento->getNumero() );
	}

	/**
	 * Test Constructor
	 *
	 * @author ezekiel
	 **/
	public function testConstructor()
	{
		$documento = new Documento();
		$this->assertNull( $documento->getTipo() );
		$this->assertEquals( Documento::$estadosStrToInt['ABIERTO'], $documento->getEstado() );
		$this->assertEquals( 0, $documento->getTotal() );
		$this->assertEquals( new \DateTime(), $documento->getFecha() );
	}

	/**
	 * Test Calcular el total de un documento
	 *
	 * @author ezekiel
	 **/
	public function testCalcularTotal()
	{
		$documento = new Documento();

		$total = 0;
		for ($i=1; $i <= 10; $i++) { 
			$lineadeDocumento = new LineadeDocumento();
			$lineadeDocumento->setPrecioT($i);
			$documento->addLineadeDocumento($lineadeDocumento);
			$total += $i;
		}

		$documento->calcularTotal();

		$this->assertEquals( $total, $documento->getTotal() );
	}
}