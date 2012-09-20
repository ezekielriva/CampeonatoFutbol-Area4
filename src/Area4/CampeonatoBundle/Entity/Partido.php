<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Partido
 *
 * @ORM\Table(name="Partido")
 * @ORM\Entity(repositoryClass="Area4\CampeonatoBundle\Entity\PartidoRepository")
 */
class Partido
{
    static public $FINALIZADO = 1;
    static public $POR_JUGARSE = 0;
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $fecha
     *
     * @ORM\Column(name="fecha", type="string", length=45, nullable=true)
     */
    private $fecha;

    /**
     * @var datetime $diahora
     *
     * @ORM\Column(name="diaHora", type="datetime", nullable=true)
     */
    private $diahora;

    /**
     * @var string $lugar
     *
     * @ORM\Column(name="lugar", type="string", length=45, nullable=true)
     */
    private $lugar;

    /**
     * @var string $fase
     *
     * @ORM\Column(name="fase", type="string", length=45, nullable=true)
     */
    private $fase;

    /**
     * @var Arbitro
     *
     * @ORM\ManyToOne(targetEntity="Arbitro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Arbitro_dni", referencedColumnName="dni")
     * })
     */
    private $arbitroDni;
    /**
     * @ORM\ManyToOne(targetEntity="Campeonato")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="Campeonato_id", referencedColumnName="id")
     * })
     **/
    private $campeonato;
    /**
     * @var Equipo $local
     *
     * @orm\ManyToOne(targetEntity="Equipo", inversedBy="locales")
     * @orm\JoinColumn(name="local", referencedColumnName="id")
     */
    private $local;
    /**
     * @var Equipo $visitante
     * @orm\ManyToOne(targetEntity="Equipo", inversedBy="visitantes" )
     * @orm\JoinColumn(name="visitante", referencedColumnName="id")
     */
    private $visitante;
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
     * Estado del partido
     * @ORM\Column(name="estado", type="integer", length="1")
     *
     * @var string
     **/
    private $estado;

    public function __construct()
    {
        $this->diaHora = new \DateTime('now');
        $this->resultadol = 0;
        $this->resultadov = 0;
        $this->estado = Partido::$POR_JUGARSE;
    }
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param string $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * Get fecha
     *
     * @return string 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set diahora
     *
     * @param datetime $diahora
     */
    public function setDiahora($diahora)
    {
        $this->diahora = $diahora;
    }

    /**
     * Get diahora
     *
     * @return datetime 
     */
    public function getDiahora()
    {
        return $this->diahora;
    }

    /**
     * Set lugar
     *
     * @param string $lugar
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
    }

    /**
     * Get lugar
     *
     * @return string 
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set fase
     *
     * @param string $fase
     */
    public function setFase($fase)
    {
        $this->fase = $fase;
    }

    /**
     * Get fase
     *
     * @return string 
     */
    public function getFase()
    {
        return $this->fase;
    }

    /**
     * Set arbitroDni
     *
     * @param Area4\CampeonatoBundle\Entity\Arbitro $arbitroDni
     */
    public function setArbitroDni(\Area4\CampeonatoBundle\Entity\Arbitro $arbitroDni)
    {
        $this->arbitroDni = $arbitroDni;
    }

    /**
     * Get arbitroDni
     *
     * @return Area4\CampeonatoBundle\Entity\Arbitro 
     */
    public function getArbitroDni()
    {
        return $this->arbitroDni;
    }

    /**
     * Set Campeonato
     *
     * @param Area4\CampeonatoBundle\Entity\Campeonato $campeonato
     */
    public function setCampeonato(\Area4\CampeonatoBundle\Entity\Campeonato $campeonato)
    {
        $this->campeonato = $campeonato;
    }

    /**
     * Get Campeonato
     *
     * @return Area4\CampeonatoBundle\Entity\Campeonato 
     */
    public function getCampeonato()
    {
        return $this->campeonato;
    }

    /**
     * Set resultadol
     *
     * @param integer $resultadol
     */
    public function setResultadol($resultadol)
    {
        $this->resultadol = $resultadol;
    }

    /**
     * Get resultadol
     *
     * @return integer 
     */
    public function getResultadol()
    {
        return $this->resultadol;
    }

    /**
     * Set resultadov
     *
     * @param integer $resultadov
     */
    public function setResultadov($resultadov)
    {
        $this->resultadov = $resultadov;
    }

    /**
     * Get resultadov
     *
     * @return integer 
     */
    public function getResultadov()
    {
        return $this->resultadov;
    }

    /**
     * Set local
     *
     * @param Area4\CampeonatoBundle\Entity\Equipo $local
     * @return false : si no se agrega el equipo local
     */
    public function setLocal(\Area4\CampeonatoBundle\Entity\Equipo $local)
    {
        if ( $local !== $this->visitante || is_null($this->visitante) )
            $this->local = $local;
        else
            return false;
    }

    /**
     * Get local
     *
     * @return Area4\CampeonatoBundle\Entity\Equipo 
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set visitante
     *
     * @param Area4\CampeonatoBundle\Entity\Equipo $visitante
     * @return false : si no se agrega el equipo visitante
     */
    public function setVisitante(\Area4\CampeonatoBundle\Entity\Equipo $visitante)
    {
        if ( $visitante !== $this->local || is_null($this->local) )
            $this->visitante = $visitante;
        else
            return false;
        
    }

    /**
     * Get visitante
     *
     * @return Area4\CampeonatoBundle\Entity\Equipo 
     */
    public function getVisitante()
    {
        return $this->visitante;
    }

    /**
     * String del partido
     *
     * @return string
     * @author ezekiel
     **/
    public function __toString()
    {
        return (string) sprintf('%s vs %s', $this->local, $this->visitante);
    }

    /**
     * Retorna la citación al partido - 20 min antes
     *
     * @return string
     * @author ezekiel
     **/
    public function getCitacion()
    {
        return date_sub( $this->diahora, date_interval_create_from_date_string('20 minute') );
    }

    /**
     * Set estado
     *
     * @param integer $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Get - string del estado
     *
     * @return string
     * @author ezekiel
     **/
    public function getEstadoToString()
    {
        if (Partido::$POR_JUGARSE === $this->estado) 
            return "POR JUGARSE";
        else 
            return "FINALIZADO";
    }
}