<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Area4\UsuarioBundle\Entity\Usuario as Usuario;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Area4\CampeonatoBundle\Entity\Jugador
 *
 * @ORM\Table(name="Jugador")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Jugador
{

    /**
     * @var integer $dni
     *
     * @ORM\Column(name="dni", type="integer", nullable=false)
     * @ORM\Id
     * @ ORM\GeneratedValue(strategy="IDENTITY")
     * @Assert\NotBlank()
     */
    private $dni;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string $apellido
     *
     * @ORM\Column(name="apellido", type="string", length=45, nullable=false)
     * @Assert\NotBlank()
     */
    private $apellido;

    /**
     * @var Equipo
     *
     * @ORM\ManyToOne(targetEntity="Equipo", inversedBy="Jugador")
     * @ORM\JoinColumn(name="Equipo_id", referencedColumnName="id")
     * @Assert\NotBlank()
     * @Assert\Type(type="Area4\CampeonatoBundle\Entity\Equipo")
     */
    private $equipo;

    /**
     * 
     * @ORM\OneToOne(targetEntity="Area4\UsuarioBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * @Assert\NotBlank()
     * @Assert\Type(type="Area4\UsuarioBundle\Entity\Usuario")
     * @var Usuario
     **/
    private $usuario;
    /**
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=false)
     * @Assert\NotBlank()
     * @var date
     **/
    private $fechadeNacimiento;
    /**
     * Slug : concatena - nombre + apellido + dni
     * @ORM\Column(name="slug", type="string", length="255", nullable=false)
     * @var string
     **/
    private $slug;
    /**
     * @ ORM\Column(name="foto", type="string", length="255", nullable=true)
     **/
    private $foto;
    /**
     * Set dni
     *
     * @param integer $dni
     */
    public function setDni($dni)
    {
        $this->dni = str_replace(".", "", $dni);
    }

    /**
     * Get dni
     *
     * @return integer 
     */
    public function getDni()
    {
        return $this->dni;
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
     * Set apellido
     *
     * @param string $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set equipo
     *
     * @param Area4\CampeonatoBundle\Entity\Equipo $equipo
     */
    public function setEquipo(\Area4\CampeonatoBundle\Entity\Equipo $equipo)
    {
        $this->equipo = $equipo;
    }

    /**
     * Get equipo
     *
     * @return Area4\CampeonatoBundle\Entity\Equipo 
     */
    public function getEquipo()
    {
        return $this->equipo;
    }

    /**
     * Set usuario
     *
     * @param Area4\UsuarioBundle\Entity\Usuario $usuario
     */
    public function setUsuario(\Area4\UsuarioBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return Area4\UsuarioBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * toString
     *
     * @return string
     * 
     **/
    public function __toString()
    {
        return sprintf("%d - %s, %s", $this->dni, $this->apellido, $this->nombre);
    }

    /**
     * Set fechadeNacimiento
     *
     * @param date $fechadeNacimiento
     */
    public function setFechadeNacimiento($fechadeNacimiento)
    {
        $this->fechadeNacimiento = $fechadeNacimiento;
    }

    /**
     * Get fechadeNacimiento
     *
     * @return date 
     */
    public function getFechadeNacimiento()
    {
        return $this->fechadeNacimiento;
    }

    /**
     * Concatena el nombre con el apellido
     *
     * @return string
     **/
    public function getNombreCompleto()
    {
        return (string) $this->apellido.', '.$this->nombre;
    }

    /**
     * Revisa si el jugador ya pertenece a un equipo
     *
     * @return true : si pertenece ya a un equipo.
     * @return false: si no pertenece a ningun equipo.
     * @author ezekielriva
     **/
    public function hasEquipo()
    {
        if (is_null($this->equipo))
            return false;
        else
            return true;
    }

    /**
     * Determina si este jugador es capitán
     *
     * @return true : si es capitán
     *         false: si no es capitán 
     * @author ezekielriva
     **/
    public function isCapitan()
    {  
        return $this->usuario->hasRole('ROLE_CAP');
    }

    /**
     * Uso para template
     *
     * @return string
     * @author ezekiel
     **/
    public function getCapitanString()
    {
        if ($this->isCapitan())
            return "[CAPITAN]";
    }

    /**
     * Realiza antes de crear
     * @ORM\PrePersist()
     */
    public function prePersist(){
        $this->slug = $this->generateSlug();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate(){
        $this->slug = $this->generateSlug();
    }

    /**
     * Genera el slug
     *
     * @return string
     * @author ezekiel
     **/
    private function generateSlug()
    {
        return (string) $this->nombre.'-'.$this->apellido.'-'.$this->dni;
    }
}