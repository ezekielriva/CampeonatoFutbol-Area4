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
     * @var Equipo
     *
     * @ORM\ManyToMany(targetEntity="Equipo", mappedBy="partido")
     */
    private $equipo;

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
        $this->equipo = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}