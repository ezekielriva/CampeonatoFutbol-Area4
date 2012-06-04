<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Partido
 *
 * @ORM\Table(name="Partido")
 * @ORM\Entity
 */
class Partido
{
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
     * @ORM\Column(name="fecha", type="string", length=45, nullable=false)
     */
    private $fecha;

    /**
     * @var datetime $diahora
     *
     * @ORM\Column(name="diaHora", type="datetime", nullable=false)
     */
    private $diahora;

    /**
     * @var string $lugar
     *
     * @ORM\Column(name="lugar", type="string", length=45, nullable=false)
     */
    private $lugar;

    /**
     * @var string $fase
     *
     * @ORM\Column(name="fase", type="string", length=45, nullable=true)
     */
    private $fase;

    /**
     * @var Equipo_has_Partido
     *
     * @ORM\ManyToOne(targetEntity="Equipo_has_Partido")
     * @ORM\JoinColumn(name="equipo_has_partido", referencedColumnName="partido_id")
     */
    private $equipo_has_partido;

    /**
     * @var Arbitro
     *
     * @ORM\ManyToOne(targetEntity="Arbitro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Arbitro_dni", referencedColumnName="dni")
     * })
     */
    private $arbitroDni;

    public function __construct()
    {
        $this->equipo_has_partido = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set equipo_has_partido
     *
     * @param Area4\CampeonatoBundle\Entity\Equipo_has_Partido $equipoHasPartido
     */
    public function setEquipoHasPartido(\Area4\CampeonatoBundle\Entity\Equipo_has_Partido $equipoHasPartido)
    {
        $this->equipo_has_partido = $equipoHasPartido;
    }

    /**
     * Get equipo_has_partido
     *
     * @return Area4\CampeonatoBundle\Entity\Equipo_has_Partido 
     */
    public function getEquipoHasPartido()
    {
        return $this->equipo_has_partido;
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
}