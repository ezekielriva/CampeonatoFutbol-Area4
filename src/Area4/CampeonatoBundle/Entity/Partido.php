<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Partido
 *
 * @ORM\Table(name="partido")
 * @ORM\Entity(repositoryClass="Area4\CampeonatoBundle\Entity\PartidoRepository")
 */
class Partido {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var date $dia
     *
     * @ORM\Column(name="dia", type="date")
     */
    private $dia;
    /**
     * @var time $hora
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;
    /**
     * @var integer $fecha
     *
     * @ORM\Column(name="fecha", type="integer")
     */
    private $fecha;
    /**
     * @var Equipo $local
     *
     * @orm\ManyToOne(targetEntity="Equipo", inversedBy="locales")
     * @orm\JoinColumn(name="local", referencedColumnName="id")
     */
    private $local;
    /**
     * @ORM\Column(type="text", nullable="true", length=2)
     */
    private $bloqueLocal;
    /**
     * @ORM\Column(type="text", nullable="true", length=10)
     */
    private $colorLocal;
    /**
     * @var Equipo $visitante
     * @orm\ManyToOne(targetEntity="Equipo", inversedBy="visitantes" )
     * @orm\JoinColumn(name="visitante", referencedColumnName="id")
     */
    private $visitante;
    /**
     * @ORM\Column(type="text", nullable="false", length=2)
     */
    private $bloqueVisitante;
    /**
     * @ORM\Column(type="text", nullable="true", length=10)
     */
    private $colorVisitante;
    /**
     * @var integer $resultadol
     *
     * @ORM\Column(name="resultadol", type="integer")
     */
    private $resultadol;
    /**
     * @var integer $resultadov
     *
     * @ORM\Column(name="resultadov", type="integer")
     */
    private $resultadov;
    /**
     * @var string $estado
     *
     * @ORM\Column(name="estado", type="string", length=20)
     */
    private $estado;
    /**
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * @var Categoria $Categoria
     */
    private $Categoria;
    /**
     * @ORM\OneToMany(targetEntity="novedad", mappedBy="Partido", cascade={"persist"})
     */
    private $novedades;
    /**
     *  @ORM\ManyToMany(targetEntity="Arbitro", mappedBy="Partido")
     */
    private $Arbitro;
    /**
     * @ORM\ManyToMany(targetEntity="Jugador", inversedBy="Partido")
     * @ ORM\JoinTable(name="partido_jugador",
     *      joinColumns={@ORM\JoinColumn(name="partido_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="jugador_id", referencedColumnName="id")}
     *      )
     */
    private $Jugador;
    /**
    * @ORM\ManyToOne(targetEntity="Campeonato")
    * @ORM\JoinColumn(name="campeonato_id", referencedColumnName="id")
    *
    */
    private $Campeonato;
    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set dia
     *
     * @param date $dia
     */
    public function setDia($dia) {
        $this->dia = $dia;
    }

    /**
     * Get dia
     *
     * @return date
     */
    public function getDia() {
        return $this->dia;
    }

    /**
     * Set hora
     *
     * @param time $hora
     */
    public function setHora($hora) {
        $this->hora = $hora;
    }

    /**
     * Get hora
     *
     * @return time
     */
    public function getHora() {
        return $this->hora;
    }

    /**
     * Set fecha
     *
     * @param integer $fecha
     */
    public function setFecha($fecha) {
        $this->fecha = ++$fecha;
    }

    /**
     * Get fecha
     *
     * @return integer
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set resultadol
     *
     * @param integer $resultadol
     */
    public function setResultadol($resultadol) {
        $this->resultadol = $resultadol;
    }

    /**
     * Get resultadol
     *
     * @return integer
     */
    public function getResultadol() {
        return $this->resultadol;
    }

    /**
     * Set resultadov
     *
     * @param integer $resultadov
     */
    public function setResultadov($resultadov) {
        $this->resultadov = $resultadov;
    }

    /**
     * Get resultadov
     *
     * @return integer
     */
    public function getResultadov() {
        return $this->resultadov;
    }

    /**
     * Set estado
     *
     * @param string $estado
     */
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * Set local
     *
     * @param Area4\CampeonatoBundle\Entity\Equipo $local
     */
    public function setLocal(\Area4\CampeonatoBundle\Entity\Equipo $local) {
        $this->local = $local;
    }

    /**
     * Get local
     *
     * @return Area4\CampeonatoBundle\Entity\Equipo 
     */
    public function getLocal() {
        return $this->local;
    }

    /**
     * Set visitante
     *
     * @param Area4\CampeonatoBundle\Entity\Equipo $visitante
     */
    public function setVisitante(\Area4\CampeonatoBundle\Entity\Equipo $visitante) {
        $this->visitante = $visitante;
    }

    /**
     * Get visitante
     *
     * @return Area4\CampeonatoBundle\Entity\Equipo 
     */
    public function getVisitante() {
        return $this->visitante;
    }

    /**
     * Set campeonato
     *
     * @param Area4\CampeonatoBundle\Entity\Campeonato $campeonato
     */
    public function setCampeonato(\Area4\CampeonatoBundle\Entity\Campeonato $campeonato) {
        $this->campeonato = $campeonato;
    }

    /**
     * Get campeonato
     *
     * @return Area4\CampeonatoBundle\Entity\Campeonato 
     */
    public function getCampeonato() {
        return $this->Campeonato;
    }

    /**
     * Set Categoria
     *
     * @param Area4\CampeonatoBundle\Entity\Categoria $categoria
     */
    public function setCategoria(\Area4\CampeonatoBundle\Entity\Categoria $categoria) {
        $this->Categoria = $categoria;
    }

    /**
     * Get Categoria
     *
     * @return Area4\CampeonatoBundle\Entity\Categoria 
     */
    public function getCategoria() {
        return $this->Categoria;
    }

    public function __construct() {
        $this->novedades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Arbitro = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add novedades
     *
     * @param Area4\CampeonatoBundle\Entity\novedad $novedades
     */
    public function addnovedad(\Area4\CampeonatoBundle\Entity\novedad $novedades) {
        $this->novedades[] = $novedades;
    }

    /**
     * Get novedades
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getNovedades() {
        return $this->novedades;
    }

    public function __toString() {
        return $this->id . '';
    }


    /**
     * Add Arbitro
     *
     * @param Area4\CampeonatoBundle\Entity\Arbitro $arbitro
     */
    public function addArbitro(\Area4\CampeonatoBundle\Entity\Arbitro $arbitro)
    {
        $this->Arbitro[] = $arbitro;
    }

    /**
     * Get Arbitro
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getArbitro()
    {
        return $this->Arbitro;
    }

    /**
     * Add Jugador
     * Antes de agregar un jugador me fijo si este se encuentra en 
     * alguno de los Equipos de Partido. Y verifica que la Categoría 
     * le permita jugar.
     * @param Area4\CampeonatoBundle\Entity\Jugador $jugador
     * @return -1 Si no esta el jugador en algun equipo del partido
     *
     */
    public function addJugador(\Area4\CampeonatoBundle\Entity\Jugador $jugador)
    {
        if($this->local != null || $this->visitante != null){
            $eq = $jugador->getEquipo()->last();
            if( $eq->getId() == $this->local->getId() || $eq->getId() == $this->visitante->getId() ){
                $cat = $this->Categoria;
                $edad = intval($this->dia->format('Y')) - intval($jugador->getFechanac()->format('Y'));
                if ($edad >= $cat->getEdadIni() && $edad <= $cat->getEdadFin())
                    $this->Jugador[] = $jugador;   
            }
            else
                return -1;
        }
    }

    /**
     * Get Jugador
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getJugador()
    {
        return $this->Jugador;
    }

    /**
     * Set bloqueLocal
     *
     * @param text $bloqueLocal
     */
    public function setBloqueLocal($bloqueLocal)
    {
        $this->bloqueLocal = $bloqueLocal;
    }

    /**
     * Get bloqueLocal
     *
     * @return text 
     */
    public function getBloqueLocal()
    {
        return $this->bloqueLocal;
    }

    /**
     * Set bloqueVisitante
     *
     * @param text $bloqueVisitante
     */
    public function setBloqueVisitante($bloqueVisitante)
    {
        $this->bloqueVisitante = $bloqueVisitante;
    }

    /**
     * Get bloqueVisitante
     *
     * @return text 
     */
    public function getBloqueVisitante()
    {
        return $this->bloqueVisitante;
    }

    /**
     * Set colorLocal
     *
     * @param text $colorLocal
     */
    public function setColorLocal($colorLocal)
    {
        $this->colorLocal = $colorLocal;
    }

    /**
     * Get colorLocal
     *
     * @return text 
     */
    public function getColorLocal()
    {
        return $this->colorLocal;
    }

    /**
     * Set colorVisitante
     *
     * @param text $colorVisitante
     */
    public function setColorVisitante($colorVisitante)
    {
        $this->colorVisitante = $colorVisitante;
    }

    /**
     * Get colorVisitante
     *
     * @return text 
     */
    public function getColorVisitante()
    {
        return $this->colorVisitante;
    }

    /**
    * Retorna el string del estado buscado
    * @param string $key : llave del partido buscado
    * @return string 
    */
    public function getEstadotoString($key)
    {
        $estados = PartidoRepository::getEstados();
        return $estados[$key];
    }
}