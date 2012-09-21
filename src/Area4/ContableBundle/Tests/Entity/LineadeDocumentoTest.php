<?php

namespace Area4\CampeonatoBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Area4\ContableBundle\Entity\LineadeDocumento, 
	Area4\ContableBundle\Entity\Producto;

class LineadeDocumentoTest extends WebTestCase
{  
	/**
	 * Test set producto
	 *
	 * @author ezekiel
	 **/
	public function testSetProducto()
	{
		$lineadeDocumento = new LineadeDocumento();
		$producto = new Producto();
		$producto->setPrecio(50);

		$lineadeDocumento->setCantidad(5);
		$lineadeDocumento->setProducto($producto);

		$this->assertEquals( 50*5, $lineadeDocumento->getPrecioT() );
	}
}