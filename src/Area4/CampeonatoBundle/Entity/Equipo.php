<?php

namespace Area4\CampeonatoBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

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
     * 
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
     * @Assert\Choice(choices={ "ColoresRepository", "getColores" }, max=3, min=1)
     */
    private $colores;

    /**
     * @var Equipo_has_Partido
     *
     * @ORM\ManyToOne(targetEntity="Equipo_has_Partido")
     * @ORM\JoinColumn(name="equipo_has_partido", referencedColumnName="equipo_id")
     */
    private $equipo_has_partido;

    public function __construct()
    {
        $this->campeonato = new \Doctrine\Common\Collections\ArrayCollection();
        $this->colores = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add campeonato
     *
     * @param Area4\CampeonatoBundle\Entity\Campeonato $campeonato
     */
    public function addCampeonato(\Area4\CampeonatoBundle\Entity\Campeonato $campeonato)
    {
        $this->campeonato[] = $campeonato;
    }

    /**
     * Get campeonato
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCampeonato()
    {
        return $this->campeonato;
    }

    /**
     * Add colores
     *
     * @param Area4\CampeonatoBundle\Entity\Colores $colores
     */
    public function addColores(\Area4\CampeonatoBundle\Entity\Colores $colores)
    {
        $this->colores[] = $colores;
    }

    /**
     * Get colores
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getColores()
    {
        return $this->colores;
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
}