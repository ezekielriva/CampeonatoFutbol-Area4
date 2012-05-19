<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Arbitro
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Arbitro {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;
    /**
     * @var string $apellido
     *
     * @ORM\Column(name="apellido", type="string", length=255)
     */
    private $apellido;
    /**
     * @var string $direccion
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;
    /**
     * @var string $telefono
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;
    /**
     * @var string $dni
     *
     * @ORM\Column(name="dni", type="string", length=10)
     */
    private $dni;
    /**
     * @ORM\ManyToMany(targetEntity="Partido", inversedBy="Arbitro")
     * @ORM\JoinTable(name="partido_arbitro",
     *      joinColumns={
     *          @ORM\JoinColumn(name="arbitro1_id", referencedColumnName="id")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="equipo_id", referencedColumnName="id")
     *      }
     * )
     */
    private $Partido;

    /**
     * Set Partido
     * @param Partido $Partido
     */
    public function setPartido($Partido){
        $this->Partido = $Partido;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     */
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido() {
        return $this->apellido;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     */
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion() {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     */
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * Set dni
     *
     * @param string $dni
     */
    public function setDni($dni) {
        $this->dni = $dni;
    }

    /**
     * Get dni
     *
     * @return string 
     */
    public function getDni() {
        return $this->dni;
    }

    /**
     * Retorna el Apellido y Nombre
     * @return String
     */
    public function __toString(){
        return $this->apellido.' '.$this->nombre;
    }

    public function __construct()
    {
        $this->Partido = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add Partido
     *
     * @param Area4\CampeonatoBundle\Entity\Partido $partido
     */
    public function addPartido(\Area4\CampeonatoBundle\Entity\Partido $partido)
    {
        $this->Partido[] = $partido;
    }

    /**
     * Get Partido
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPartido()
    {
        return $this->Partido;
    }
}