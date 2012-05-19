<?php

namespace Area4\CampeonatoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase,
    Area4\CampeonatoBundle\Entity\Jugador;

class JugadorControllerTest extends \PHPUnit_Extensions_SeleniumTestCase
{   

    public function testRequirements()
    {
        return null;
    }


    /**
    *
    */
    public function setUp()
    {
        $this->setBrowser('*firefox');
        $this->setBrowserUrl('http://localhost/atah/web/app_dev.php/jugador/new');

    }
    /**
    * @author Ezequiel
    * @email ezerivadeneiral@gmail.com
    * @version 1.0
    */
    public function testJugadorNewEscenario()
    {

        $this->open("/atah/web/app_dev.php/jugador/new");
        $this->type("id=area4_campeonatobundle_jugadortype_nombre", "Samuel L.");
        $this->type("id=area4_campeonatobundle_jugadortype_apellido", "Fisher");
        $this->type("id=area4_campeonatobundle_jugadortype_direccion", "St. Crisostomo 110");
        $this->type("id=area4_campeonatobundle_jugadortype_dni", "24987365");
        $this->type("id=area4_campeonatobundle_jugadortype_telefono", "4236589");
        $this->select("id=area4_campeonatobundle_jugadortype_fechanac_year", "label=1990");
        $this->select("id=area4_campeonatobundle_jugadortype_fechanac_month", "label=10");
        $this->select("id=area4_campeonatobundle_jugadortype_fechanac_day", "label=20");
        $this->addSelection("id=area4_campeonatobundle_jugadortype_Equipo", "label=NATACION");
        $this->select("id=area4_campeonatobundle_jugadortype_bloque", "label=B");
        $this->addSelection("id=area4_campeonatobundle_jugadortype_Categoria", "label=Primera e Intermedia");
        $this->select("id=area4_campeonatobundle_jugadortype_bloque", "label=Sin Bloque");
        $this->click("css=input.button");
        $this->waitForPageToLoad("30000");
        $this->click("css=a > strong");
    }
    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/jugador/');
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'jugador[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertTrue($crawler->filter('td:contains("Test")')->count() > 0);

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'jugador[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertTrue($crawler->filter('[value="Foo"]')->count() > 0);

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }
    */
}