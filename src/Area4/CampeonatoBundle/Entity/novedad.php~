<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\novedad
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Area4\CampeonatoBundle\Entity\novedadRepository")
 */
class novedad {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Partido")
     * @ORM\JoinColumn(name="Partido_id", referencedColumnName="id")
     */
    private $Partido;
    /**
     * @var integer $minuto
     *
     * @ORM\Column(name="minuto", type="integer", nullable="true")
     */
    private $minuto;
    /**
     * @ ORM\ManyToOne(targetEntity="Jugador")
     * @ ORM\JoinColumn(name="Jugador_id", referencedColumnName="id")
     */
    private $Jugador;
    /**
     * @ORM\Column(name="tipo_novedad", type="string", length="255", nullable="true")
     * @var $tipo_novedad string
     */
    private $tipo_novedad;
    /**
     * @ORM\Column(name="obs", type="string", length="255", nullable="true")
     * @var $obs string
     */
    private $obs;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set minuto
     *
     * @param integer $minuto
     */
    public function setMinuto($minuto) {
        $this->minuto = $minuto;
    }

    /**
     * Get minuto
     *
     * @return integer 
     */
    public function getMinuto() {
        return $this->minuto;
    }

    /**
     * Set obs
     *
     * @param string $obs
     */
    public function setObs($obs) {
        $this->obs = $obs;
    }

    /**
     * Get obs
     *
     * @return string 
     */
    public function getObs() {
        return $this->obs;
    }

    /**
     * Set Jugador
     *
     * @param Area4\CampeonatoBundle\Entity\Jugador $jugador
     */
    public function setJugador(\Area4\CampeonatoBundle\Entity\Jugador $jugador) {
        $this->Jugador = $jugador;
    }

    /**
     * Get Jugador
     *
     * @return Area4\CampeonatoBundle\Entity\Jugador 
     */
    public function getJugador() {
        return $this->Jugador;
    }

    /**
     * Set tipo_novedad
     *
     * @param string $tipoNovedad
     */
    public function setTipoNovedad($tipoNovedad) {
        $this->tipo_novedad = $tipoNovedad;
    }

    /**
     * Get tipo_novedad
     *
     * @return string
     */
    public function getTipoNovedad() {
        return $this->tipo_novedad;
    }

    /**
     * Retorna el tipo de novedad en String
     * @param integer $i
     * @return string
     */
    public function getTipoNovedadtoString($i){
        switch($i){
            case 0: return 'Gol-Local';
            case 1: return 'Gol-Visitante';
            case 2: return 'Tarjeta Verde';
            case 3: return 'Tarjeta Amarilla';
            case 4: return 'Tarjeta Roja';
            case 5: return 'Penal';
            case 6: return 'Suspención de Partido';
            case 7: return 'Lesión';
        }
    }

    /**
     * Set Partido
     *
     * @param Area4\CampeonatoBundle\Entity\Partido $partido
     */
    public function setPartido(\Area4\CampeonatoBundle\Entity\Partido $partido) {
        $this->Partido = $partido;
    }

    /**
     * Get Partido
     *
     * @return Area4\CampeonatoBundle\Entity\Partido 
     */
    public function getPartido() {
        return $this->Partido;
    }

    public function __toString(){
        return $this->id.'';
    }

}