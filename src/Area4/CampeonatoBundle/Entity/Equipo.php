<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Equipo
 *
 * @ORM\Table(name="Equipo")
 * @ORM\Entity
 */
class Equipo
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
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @var Campeonato
     *
     * @ORM\ManyToMany(targetEntity="Campeonato", mappedBy="equipo")
     */
    private $campeonato;

    /**
     * @var Colores
     *
     * @ORM\ManyToMany(targetEntity="Colores", inversedBy="equipo")
     * @ORM\JoinTable(name="equipo_has_colores",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Equipo_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Colores_id", referencedColumnName="id")
     *   }
     * )
     */
    private $colores;

    /**
     * @var Partido
     *
     * @ORM\ManyToMany(targetEntity="Partido", inversedBy="equipo")
     * @ORM\JoinTable(name="equipo_has_partido",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Equipo_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Partido_id", referencedColumnName="id")
     *   }
     * )
     */
    private $partido;

    public function __construct()
    {
        $this->campeonato = new \Doctrine\Common\Collections\ArrayCollection();
    $this->colores = new \Doctrine\Common\Collections\ArrayCollection();
    $this->partido = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}