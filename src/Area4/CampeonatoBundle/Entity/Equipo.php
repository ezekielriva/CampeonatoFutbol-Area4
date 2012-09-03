<?php

namespace Area4\CampeonatoBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Equipo
 *
 * @ORM\Table(name="Equipo")
 * @ORM\Entity(repositoryClass="Area4\CampeonatoBundle\Entity\EquipoRepository")
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
     * @ORM\JoinTable(name="Equipo_has_Colores",
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
     * Cupos disponibles en los equipos
     * @ORM\Column(name="cupos", type="integer", nullable="false")
     * @var integer
     **/
    private $cupos;

    /**
     * @var jugadores
     *
     * @ORM\OneToMany(targetEntity="Equipo", mappedBy="Jugador")
     */
    private $jugadores;

    public function __construct()
    {
        $this->cupos = 9;
        $this->campeonato = new \Doctrine\Common\Collections\ArrayCollection();
        $this->colores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jugadores = new \Doctrine\Common\Collections\ArrayCollection();
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
     * toString
     *
     * @return string
     **/
    public function __toString ()
    {
        return $this->nombre;
    }

    /**
     * Set cupos
     *
     * @param integer $cupos
     */
    public function setCupos($cupos)
    {
        $this->cupos = $cupos;
    }

    /**
     * Get cupos
     *
     * @return integer 
     */
    public function getCupos()
    {
        return $this->cupos;
    }

    /**
     * Add jugadores
     *
     * @param Area4\CampeonatoBundle\Entity\Jugador $jugadores
     */
    public function addJugador(\Area4\CampeonatoBundle\Entity\Jugador $jugadores)
    {
        if ($this->cupos > 0) {
            $this->jugadores[] = $jugadores;
            $this->cupos = $this->cupos - 1;
        } 
        return;
        
    }

    /**
     * Get jugadores
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getJugadores()
    {
        return $this->jugadores;
    }

    /**
     * Verificamos si juega en un campeonato
     *
     * @return true : juega en ese campeonato
     *         false: no juega en ese campeonato
     * @author ezekiel
     **/
    public function juegaInCameponato($Campeonato)
    {   
        foreach ($this->getCampeonato as $camp) {
            if ($camp->getId() === $Campeonato->getId())
                return true;
        }
        return false;
    }

    /**
     * Retorna el capitan del equipo
     *
     * @return Jugador
     * @author ezekiel
     **/
    public function getCapitan()
    {
        if (!$this->jugadores) {
            foreach ($this->jugadores as $jugador) {
                $usuario = $jugador->getUsuario();

                if ($usuario->hasRole('ROLE_CAP'))
                    return $jugador;
            }
        }
        return new Jugador();
    }
}