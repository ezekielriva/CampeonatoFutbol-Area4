<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Inscripciones
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Area4\CampeonatoBundle\Entity\InscripcionesRepository")
 */
class Inscripciones
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var date $fecha_inicio
     *
     * @ORM\Column(name="fecha_inicio", type="date")
     */
    private $fecha_inicio;

    /**
     * @var date $fecha_finalizacion
     *
     * @ORM\Column(name="fecha_finalizacion", type="date")
     */
    private $fecha_finalizacion;

    /**
     * @var string $tipo
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var string $Campeonato
     *
     * @ORM\ManyToOne(targetEntity="Campeonato")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Campeonato_id", referencedColumnName="id")
     * })
     */
    private $Campeonato;

    /**
     * Constructor
     *
     **/
    public function __construct()
    {
        $this->fecha_inicio = new \DateTime('now');
        $this->fecha_finalizacion = new \DateTime('now');
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
     * Set fecha_inicio
     *
     * @param date $fechaInicio
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fecha_inicio = $fechaInicio;
    }

    /**
     * Get fecha_inicio
     *
     * @return date 
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * Set fecha_finalizacion
     *
     * @param date $fechaFinalizacion
     */
    public function setFechaFinalizacion($fechaFinalizacion)
    {
        if ( $fechaFinalizacion >= $this->fecha_inicio )
            $this->fecha_finalizacion = $fechaFinalizacion;
        else
            return false;
    }

    /**
     * Get fecha_finalizacion
     *
     * @return date 
     */
    public function getFechaFinalizacion()
    {
        return $this->fecha_finalizacion;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set Campeonato
     *
     * @param string $campeonato
     */
    public function setCampeonato($campeonato)
    {
        $this->Campeonato = $campeonato;
    }

    /**
     * Get Campeonato
     *
     * @return string 
     */
    public function getCampeonato()
    {
        return $this->Campeonato;
    }
}