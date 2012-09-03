<?php



class JugadorFuncional extends PHPUnit_Extensions_SeleniumTestCase
{
  protected function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("http://localhost/atah/web/app_dev.php/jugador/new");
  }

  public function InscribirJugadorTest()
  {
    $this->assertTrue(false);
    $this->open("/CampeonatoFutbol-Area4/web/app.php/jugador/inscribirse");
    $this->type("id=area4_campeonatobundle_jugadortype_dni", "1234567890");
    $this->type("id=area4_campeonatobundle_jugadortype_nombre", "Anonimo");
    $this->type("id=area4_campeonatobundle_jugadortype_apellido", "Anonimo 1");
    $this->type("id=area4_campeonatobundle_jugadortype_fechadeNacimiento", "00/00/0001");
    $this->type("id=fos_user_registration_form_plainPassword_first", "123456789");
    $this->type("id=fos_user_registration_form_plainPassword_second", "123456789");
    $this->click("css=button[type=\"button\"]");
  }
}