<?php

namespace Area4\CampeonatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area4\CampeonatoBundle\Entity\Campeonato
 *
 * @ORM\Table(name="Campeonato")
 * @ORM\Entity(repositoryClass="Area4\CampeonatoBundle\Entity\CampeonatoRepository")
 */
class Campeonato
{
    static public $EN_JUEGO = 0;
    static public $FINALIZADO = 1;
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
     * @var string $provincia
     *
     * @ORM\Column(name="provincia", type="string", length=45, nullable=false)
     */
    private $provincia;

    /**
     * @var Equipo
     *
     * @ORM\ManyToMany(targetEntity="Equipo", inversedBy="campeonato")
     * @ORM\JoinTable(name="campeonato_has_equipo",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Campeonato_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Equipo_id", referencedColumnName="id")
     *   }
     * )
     */
    private $equipo;

    /**
     * @ORM\Column(name="finalizo", type="integer", length=1, nullable=false)
     */
    private $finalizo;
    
    /**
     * @ORM\Column(name="categoria", type="string", length=1, nullable=false)
     */
    private $categoria;
    /**
     * @ORM\ManyToOne(targetEntity="\Area4\UsuarioBundle\Entity\Usuario", inversedBy="Campeonato")
     */
    private $usuario;

    public function __construct()
    {
        $this->finalizo = Campeonato::$EN_JUEGO;
        $this->provincia = 'TUCUMAN';
        $this->equipo = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set provincia
     *
     * @param string $provincia
     */
    public function setProvincia($provincia)
    {
        $this->provincia = strtoupper($provincia);
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Add equipo
     *
     * @param Area4\CampeonatoBundle\Entity\Equipo $equipo
     */
    public function addEquipo(\Area4\CampeonatoBundle\Entity\Equipo $equipo)
    {
        $this->equipo[] = $equipo;
    }

    /**
     * Get equipo
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEquipo()
    {
        return $this->equipo;
    }

    /**
     * Set finalizo
     *
     * @param int $finalizo
     */
    public function setFinalizo($finalizo)
    {
        $this->finalizo = $finalizo;
    }

    /**
     * Get finalizo
     *
     * @return boolean 
     */
    public function getFinalizo()
    {
        if ($this->finalizo === Campeonato::$EN_JUEGO){
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * toString
     *
     **/
    public function __toString()
    {
        return (string) $this->id;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * Get categoria
     *
     * @return string 
     */
    public function getCategoria()
    {
        return $this->categoria;
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
     * Obtiene el string de finalizo
     *
     * @return string
     * @author ezekiel
     **/
    public function finalizoToString()
    {
        if ($this->finalizo === Campeonato::$EN_JUEGO)
            return "JUGANDOSE";
        else
            return "FINALIZADO";
    }
}