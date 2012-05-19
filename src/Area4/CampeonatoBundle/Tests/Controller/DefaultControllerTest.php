<?php

namespace Area4\CampeonatoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testBasico()
    {
        $this->assertEquals(1, 1, "TestBasico: Probar que 1 es igual a 1");
    }
}
